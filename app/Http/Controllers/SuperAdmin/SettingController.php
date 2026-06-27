<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'community_name'                => ['nullable', 'string'],
            'community_logo'                => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'delete_community_logo'         => ['nullable', 'string'],
            'email'                         => ['nullable', 'email'],
            'telephone'                     => ['nullable', 'string'],
            'address'                       => ['nullable', 'string'],
            'city'                          => ['nullable', 'string'],
            'x_account_url'                 => ['nullable', 'string'],
            'facebook_account_url'          => ['nullable', 'string'],
            'linkedin_account_url'          => ['nullable', 'string'],
            'skype_account_url'             => ['nullable', 'string'],
            'instagram_account_url'         => ['nullable', 'string'],
            'youtube_account_url'           => ['nullable', 'string'],
            'account_holder_name'           => ['nullable', 'string'],
            'account_number'                => ['nullable', 'string'],
            'bank_name'                     => ['nullable', 'string'],
            'membership_fee'                => ['nullable', 'numeric'],
            'membership_duration'           => ['nullable', 'numeric'],
            'invoice_countdown'             => ['nullable', 'numeric'],
            'primary_color'                 => ['nullable', 'string'],
            'surface_color'                 => ['nullable', 'string'],
            'background_image'              => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'delete_background_image'       => ['nullable', 'string'],
            'hero_title'                    => ['nullable', 'string'],
            'hero_description'              => ['nullable', 'string'],
            'about_image'                   => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'delete_about_image'            => ['nullable', 'string'],
            'about_title'                   => ['nullable', 'string'],
            'about_description'             => ['nullable', 'string'],
            'member_stat_title'             => ['nullable', 'string'],
            'member_stat_description'       => ['nullable', 'string'],
            'stat_member_active'            => ['nullable', 'numeric'],
            'stat_member_inactive'          => ['nullable', 'numeric'],
            'stat_member_company'           => ['nullable', 'numeric'],
            'stat_member_personal'          => ['nullable', 'numeric'],
            'card_background_image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'delete_card_background_image'  => ['nullable', 'string'],
            'leader_sign_image'             => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'delete_leader_sign_image'      => ['nullable', 'string'],
        ]);

        Setting::set('community_name', $request->input('community_name'));

        if ($request->boolean('delete_community_logo')) {
            Setting::del('community_logo');
        } else if (!empty($validated['community_logo'])) {
            Setting::set('community_logo', $request->file('community_logo')->store());
        }

        Setting::set('email', $request->input('email'));
        Setting::set('telephone', $request->input('telephone'));
        Setting::set('address', $request->input('address'));
        Setting::set('city', $request->input('city'));
        Setting::set('x_account_url', $request->input('x_account_url'));
        Setting::set('facebook_account_url', $request->input('facebook_account_url'));
        Setting::set('linkedin_account_url', $request->input('linkedin_account_url'));
        Setting::set('skype_account_url', $request->input('skype_account_url'));
        Setting::set('instagram_account_url', $request->input('instagram_account_url'));
        Setting::set('youtube_account_url', $request->input('youtube_account_url'));
        Setting::set('account_holder_name', $request->input('account_holder_name'));
        Setting::set('account_number', $request->input('account_number'));
        Setting::set('bank_name', $request->input('bank_name'));
        Setting::set('membership_fee', $request->input('membership_fee'));
        Setting::set('membership_duration', $request->input('membership_duration'));
        Setting::set('invoice_countdown', $request->input('invoice_countdown'));
        Setting::set('primary_color', $request->input('primary_color'));
        Setting::set('surface_color', $request->input('surface_color'));

        if ($request->boolean('delete_background_image')) {
            Setting::del('background_image');
        } else if (!empty($validated['background_image'])) {
            Setting::set('background_image', $request->file('background_image')->store());
        }

        Setting::set('hero_title', $request->input('hero_title'));
        Setting::set('hero_description', $request->input('hero_description'));

        if ($request->boolean('delete_about_image')) {
            Setting::del('about_image');
        } else if (!empty($validated['about_image'])) {
            Setting::set('about_image', $request->file('about_image')->store());
        }

        Setting::set('about_title', $request->input('about_title'));
        Setting::set('about_description', $request->input('about_description'));
        Setting::set('member_stat_title', $request->input('member_stat_title'));
        Setting::set('member_stat_description', $request->input('member_stat_description'));
        Setting::set('stat_member_active', $request->input('stat_member_active'));
        Setting::set('stat_member_inactive', $request->input('stat_member_inactive'));
        Setting::set('stat_member_company', $request->input('stat_member_company'));
        Setting::set('stat_member_personal', $request->input('stat_member_personal'));

        if ($request->boolean('delete_card_background_image')) {
            Setting::del('card_background_image');
        } else if (!empty($validated['card_background_image'])) {
            Setting::set('card_background_image', $request->file('card_background_image')->store());
        }

        if ($request->boolean('delete_leader_sign_image')) {
            Setting::del('leader_sign_image');
        } else if (!empty($validated['leader_sign_image'])) {
            Setting::set('leader_sign_image', $request->file('leader_sign_image')->store());
        }

        return Inertia::location(route('super_admin.settings.index'));
    }
}
