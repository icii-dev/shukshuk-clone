<?php

use Illuminate\Database\Seeder;

class ComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = $this->findComponent('banner.1');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Banner Title',
                'value'        => 'Banner Title',
                'details'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'type'         => 'image',
                'order'        => 1,
                'group'        => 'Banner',
            ])->save();
        }

        $setting = $this->findComponent('banner.2');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Banner Title 2',
                'value'        => 'Banner Title 2',
                'details'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'type'         => 'image',
                'order'        => 1,
                'group'        => 'Banner',
            ])->save();
        }

        $setting = $this->findComponent('banner.3');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Banner Title 3',
                'value'        => 'Banner Title 3',
                'details'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'type'         => 'image',
                'order'        => 1,
                'group'        => 'Banner',
            ])->save();
        }

        $setting = $this->findComponent('banner.4');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Banner Title 4',
                'value'        => 'Banner Title 4',
                'details'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'type'         => 'image',
                'order'        => 1,
                'group'        => 'Banner',
            ])->save();
        }
    }

    /**
     * [setting description].
     *
     * @param [type] $key [description]
     *
     * @return [type] [description]
     */
    protected function findComponent($key)
    {
        return \App\Model\Component::firstOrNew(['key' => $key]);
    }
}
