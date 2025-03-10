
@if($authMethod === 'system' && $user->system_name == 'public')
    <p class="mb-none text-warn">{{ trans('settings.users_system_public') }}</p>
@endif

<div class="pt-m">
    <label class="setting-list-label">{{ trans('settings.users_details') }}</label>
    @if($authMethod === 'standard')
        <p class="small">{{ trans('settings.users_details_desc') }}</p>
    @endif
    @if($authMethod === 'ldap' || $authMethod === 'system')
        <p class="small">{{ trans('settings.users_details_desc_no_email') }}</p>
    @endif
    <div class="grid half mt-m gap-xl mb-l">
        <div>
            <label for="name">{{ trans('auth.name') }}</label>
            @include('form.text', ['name' => 'name', 'disabled' => true])
        </div>
        <div>
            @if($authMethod !== 'ldap' || userCan('users-manage'))
                <label for="email">{{ trans('auth.email') }}</label>
                @include('form.text', ['name' => 'email', 'disabled' => true])
            @endif
        </div>
    </div>
    <div>
        <div class="form-group collapsible mb-none" component="collapsible" id="external-auth-field">
            <button refs="collapsible@trigger" type="button" class="collapse-title text-link" aria-expanded="false">
                <label for="external-auth">{{ trans('settings.users_external_auth_id') }}</label>
            </button>
            <div refs="collapsible@content" class="collapse-content stretch-inputs">
                <p class="small">{{ trans('settings.users_external_auth_id_desc') }}</p>
                @include('form.text', ['name' => 'external_auth_id'])
            </div>
        </div>
    </div>
</div>

@if(userCan('users-manage'))
<div>
    <label for="role" class="setting-list-label">{{ trans('settings.users_role') }}</label>
    <p class="small">{{ trans('settings.users_role_desc') }}</p>
    <div class="mt-m">
        @include('form.role-checkboxes', ['name' => 'roles', 'roles' => $roles])
    </div>
</div>

@endif

@if($authMethod === 'standard')
    <div component="new-user-password">
        <label class="setting-list-label">{{ trans('settings.users_password') }}</label>

        @if(!isset($model))
            <p class="small">
                {{ trans('settings.users_send_invite_text') }}
            </p>

            @include('form.toggle-switch', [
                'name' => 'send_invite',
                'value' => old('send_invite', 'true') === 'true',
                'label' => trans('settings.users_send_invite_option')
            ])
        @endif

        <div refs="new-user-password@input-container" @if(!isset($model)) style="display: none;" @endif>
            <p class="small mb-none">{{ trans('settings.users_password_desc') }}</p>
            @if(isset($model))
                <p class="small">
                    {{ trans('settings.users_password_warning') }}
                </p>
            @endif
            <div class="grid half mt-m gap-xl">
                <div>
                    <label for="password">{{ trans('auth.password') }}</label>
                    @include('form.password', ['name' => 'password', 'autocomplete' => 'new-password'])
                </div>
                <div>
                    <label for="password-confirm">{{ trans('auth.password_confirm') }}</label>
                    @include('form.password', ['name' => 'password-confirm'])
                </div>
            </div>
        </div>

    </div>
@endif
