<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">{{ __('BD') }}</a>
            <a href="#" class="simple-text logo-normal">{{ __('Black Dashboard') }}</a>
        </div>
        <ul class="nav">
            <li @if ($pageSlug == 'dashboard') class="active " @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'exchange') class="active " @endif>
                <a href="{{ route('exchange') }}">
                    <i class="tim-icons icon-coins"></i>
                    <p>{{ __('Exchange') }}</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#laravel-examples" aria-expanded="true">
                    <i class="tim-icons icon-settings" ></i>
                    <span class="nav-link-text" >{{ __('Space') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse show" id="laravel-examples">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'create users') class="active " @endif>
                            <a href="{{ route('pages.create.users') }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('Create Users') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'add details') class="active " @endif>
                            <a href="{{ route('add.details') }}">
                                <i class="tim-icons icon-wallet-43"></i>
                                <p>{{ __('Add Details') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'all users') class="active " @endif>
                            <a href="{{ route('check.users') }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>{{ __('All Users') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li @if ($pageSlug == 'market board') class="active " @endif>
                <a href="{{ route('market.board')  }}">
                    <i class="tim-icons icon-components"></i>
                    <p>{{ __('Market Board') }}</p>
                </a>
            </li>




            <!-- <li @if ($pageSlug == 'profile') class="active " @endif>
                <a href="{{ route('profile.edit')  }}">
                    <i class="tim-icons icon-single-02"></i>
                    <p>{{ __('User Profile') }}</p>
                </a>
            </li> -->
            <li @if ($pageSlug == 'icons') class="active " @endif>
                <a href="{{ route('pages.icons') }}">
                    <i class="tim-icons icon-atom"></i>
                    <p>{{ __('Icons') }}</p>
                </a>
            </li>
            <!-- <li @if ($pageSlug == 'notifications') class="active " @endif>
                <a href="{{ route('pages.notifications') }}">
                    <i class="tim-icons icon-bell-55"></i>
                    <p>{{ __('Notifications') }}</p>
                </a>
            </li> -->
            <!-- <li @if ($pageSlug == 'tables') class="active " @endif>
                <a href="{{ route('pages.tables') }}">
                    <i class="tim-icons icon-puzzle-10"></i>
                    <p>{{ __('Table List') }}</p>
                </a>
            </li> -->
        </ul>
    </div>
</div>
