<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeviceController extends Controller
{
    private function checkDeviceStatus($ip)
    {
        $command = 'ping -n 1 ' . escapeshellarg($ip);
        exec($command . ' 1>nul 2>&1', $output, $status);
        return $status === 0 ? 'ONLINE' : 'OFFLINE';
    }

    public function index(Request $request)
    {
        $devices = Device::all();
        
        foreach ($devices as $device) {
            $device->status = $this->checkDeviceStatus($device->ip_address);
            $device->save();
        }

        $onlineCount = $devices->where('status', 'ONLINE')->count();
        $offlineCount = $devices->where('status', 'OFFLINE')->count();

        $search = $request->query('search');
        if ($search) {
            $devices = $devices->filter(function ($device) use ($search) {
                return stripos($device->name, $search) !== false || stripos($device->ip_address, $search) !== false;
            });
        }

        $filter = $request->query('filter');
        if ($filter === 'online') {
            $devices = $devices->where('status', 'ONLINE');
        } elseif ($filter === 'offline') {
            $devices = $devices->where('status', 'OFFLINE');
        }

        return view('devices.index', compact('devices', 'onlineCount', 'offlineCount'));
    }

    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ip_address' => 'required|ip',
        ]);

        Device::create($request->all());

        return redirect()->route('devices.index')->with('success', 'Device added successfully.');
    }

    public function show(Device $device)
    {
        $device->status = $this->checkDeviceStatus($device->ip_address);
        return view('devices.show', compact('device'));
    }

    public function edit(Device $device)
    {
        return view('devices.edit', compact('device'));
    }

    public function update(Request $request, Device $device)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ip_address' => 'required|ip|unique:devices,ip_address,' . $device->id,
        ]);

        $device->update($request->all());

        return redirect()->route('devices.index')->with('success', 'Device updated successfully.');
    }

    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('devices.index')->with('success', 'Device deleted successfully.');
    }
}

