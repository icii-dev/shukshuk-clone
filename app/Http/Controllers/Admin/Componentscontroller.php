<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Model\Component;

class ComponentsController extends Controller
{
    public function store(Request $request)
    {
        $component = new Component();
        // Check permission
        $this->authorize('add', $component);

        $key = $request->input('key');
        $key_check = $component->where('key', $key)->get()->count();

        if ($key_check > 0) {
            return back()->with([
                'message'    => __('voyager::settings.key_already_exists', ['key' => $key]),
                'alert-type' => 'error',
            ]);
        }

        $lastSetting = Voyager::model('Setting')->orderBy('order', 'DESC')->first();

        if (is_null($lastSetting)) {
            $order = 0;
        } else {
            $order = intval($lastSetting->order) + 1;
        }

        $request->merge(['order' => $order]);
        $request->merge(['value' => '']);
        $request->merge(['key' => $key]);

        $component->create($request->except('setting_tab'));

        request()->flashOnly('setting_tab');

        return back()->with([
            'message'    => __('voyager::settings.successfully_created'),
            'alert-type' => 'success',
        ]);
    }

    public function index()
    {
        $component = new Component();
        // Check permission
        $this->authorize('browse', $component);

        $data = $component->orderBy('order', 'ASC')->get();

        $settings = [];
        $settings[__('voyager::settings.group_general')] = [];
        foreach ($data as $d) {
            if ($d->group == '' || $d->group == __('voyager::settings.group_general')) {
                $settings[__('voyager::settings.group_general')][] = $d;
            } else {
                $settings[$d->group][] = $d;
            }
        }
        if (count($settings[__('voyager::settings.group_general')]) == 0) {
            unset($settings[__('voyager::settings.group_general')]);
        }

        $groups_data = $component->select('group')->distinct()->get();
        $groups = [];
        foreach ($groups_data as $group) {
            if ($group->group != '') {
                $groups[] = $group->group;
            }
        }
        $active = (request()->session()->has('setting_tab')) ? request()->session()->get('setting_tab') : old('setting_tab', key($settings));
        return Voyager::view('admin.settings.index', compact('settings', 'groups', 'active'));
    }

    public function update(Request $request)
    {
        $component = new Component();
        // Check permission
        $this->authorize('edit', $component);

        $settings = Component::all();

        foreach ($settings as $component) {
            $content = $this->getContentBasedOnType($request, 'components', (object) [
                'type'    => $component->type,
                'field'   => str_replace('.', '_', $component->key),
                'details' => $component->details,
                'group'   => $component->group,
            ]);

            if (($component->type == 'file' || $component->type == 'image') && $content != null) {
                $component->value = $content;
            }

            $key = preg_replace('/^'.Str::slug($component->group).'./i', '', $component->key);

            $component->group = $request->input(str_replace('.', '_', $component->key).'_group');
            $component->key = implode('.', [Str::slug($component->group), $key]);

            // find and update all part
            foreach ($request->except('_token', '_method', 'setting_tab') as $key => $part){
                $inKey = explode('__', $key);
                if(isset($inKey[1])){
                    $inKey[0] = str_replace('_', '.', $inKey[0]);
                    if($component->key === $inKey[0]){
                        $component[$inKey[1]] = $part;
                    }
                }

            }
            $component->save();

        }
        request()->flashOnly('setting_tab');

        return back()->with([
            'message'    => __('voyager::settings.successfully_saved'),
            'alert-type' => 'success',
        ]);
    }

    public function delete($id)
    {
        $component = Component::find($id);
        // Check permission
        $this->authorize('delete', $component);

        $component->delete();

        request()->session()->flash('setting_tab', $component->group);

        return back()->with([
            'message'    => __('voyager::settings.successfully_deleted'),
            'alert-type' => 'success',
        ]);
    }

    public function delete_value($id)
    {
        $setting = Component::find($id);

        // Check permission
        $this->authorize('delete', $setting);

        if (isset($setting->id)) {
            // If the type is an image... Then delete it
            if ($setting->type == 'image') {
                if (Storage::disk(config('voyager.storage.disk'))->exists($setting->value)) {
                    Storage::disk(config('voyager.storage.disk'))->delete($setting->value);
                }
            }
            $setting->value = '';
            $setting->save();
        }

        request()->session()->flash('setting_tab', $setting->group);

        return back()->with([
            'message'    => __('voyager::settings.successfully_removed', ['name' => $setting->display_name]),
            'alert-type' => 'success',
        ]);
    }

    public function move_up($id)
    {
        $component = new Component();
        // Check permission
        $this->authorize('edit', $component);

        $setting = $component->find($id);

        // Check permission
        $this->authorize('browse', $setting);

        $swapOrder = $setting->order;
        $previousSetting = Component::where('order', '<', $swapOrder)
            ->where('group', $setting->group)
            ->orderBy('order', 'DESC')->first();
        $data = [
            'message'    => __('voyager::settings.already_at_top'),
            'alert-type' => 'error',
        ];

        if (isset($previousSetting->order)) {
            $setting->order = $previousSetting->order;
            $setting->save();
            $previousSetting->order = $swapOrder;
            $previousSetting->save();

            $data = [
                'message'    => __('voyager::settings.moved_order_up', ['name' => $setting->display_name]),
                'alert-type' => 'success',
            ];
        }

        request()->session()->flash('setting_tab', $setting->group);

        return back()->with($data);
    }

    public function move_down($id)
    {
        $component = new Component();
        // Check permission
        $this->authorize('edit', $component);

        $setting = $component->find($id);

        // Check permission
        $this->authorize('browse', $setting);

        $swapOrder = $setting->order;

        $previousSetting = Component::where('order', '>', $swapOrder)
            ->where('group', $setting->group)
            ->orderBy('order', 'ASC')->first();
        $data = [
            'message'    => __('voyager::settings.already_at_bottom'),
            'alert-type' => 'error',
        ];

        if (isset($previousSetting->order)) {
            $setting->order = $previousSetting->order;
            $setting->save();
            $previousSetting->order = $swapOrder;
            $previousSetting->save();

            $data = [
                'message'    => __('voyager::settings.moved_order_down', ['name' => $setting->display_name]),
                'alert-type' => 'success',
            ];
        }

        request()->session()->flash('setting_tab', $setting->group);

        return back()->with($data);
    }
}
