<div>
    <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">{{ $notificationCount != 'no' ? $notificationCount : "" }}</span>
          </a>
          <!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have {{$notificationCount}} new notifications
              <a wire:click='showAllNotification'><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            @forelse ($notifications as $notification)
            <li class="notification-item {{ $notification->read_at != NULL ? 'bg-light' : '' }}" onclick="readNotification('{{$notification->id}}')">
              <i class="
                    {{
                    ($notification->data['noty']['type'] == 'success' ? 'bi bi-check-circle text-success' : ($notification->data['noty']['type'] == 'warning' ? 'bi bi-exclamation-circle text-warning' : ($notification->data['noty']['type'] == 'info' ? 'bi bi-info-circle text-primary' : 'bi bi-x-circle text-danger')))
                    }}
                    "></i>
              <div>
                <h4>{{$notification->data['noty']['title']}}</h4>
                <p>{{$notification->data['noty']['message']}}</p>
                <p>{{ $notification->data['noty']['time']}}</p>
              </div>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            @empty

            @endforelse

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a wire:click='showAllNotification'>Show all notifications</a>
            </li>

          </ul>
          <!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">{{ $messageCount > 0 ? $messageCount : "" }}</span>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              {{ $messageCount > 0 ? "You have $messageCount new messages " : 'You have no new messages'}}
              <a href="{{ $route }}"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            @forelse ($messages as $message)
             <li class="message-item">
                <a href="#">
                  <img src="{{ $message['user']->profileImg()}}" alt="" class="rounded-circle">
                  <div>
                    <h4>{{ ucwords(strtolower($message['user']->fullname())) }}</h4>
                    <p>{{ Str::substr($message['message'], 0, 10) }}..</p>
                    <p>{{ $message['time'] }}</p>
                  </div>
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
            @empty

            @endforelse
{{--
            <li class="message-item">
              <a href="#">
                <img src="{{ asset('assets/img/messages-2.jpg') }}" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="{{ asset('assets/img/messages-3.jpg') }}" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li> --}}

            <li class="dropdown-footer">
              <a href="{{ $route }}">Show all messages</a>
            </li>

          </ul>
          <!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{ Auth::user()->profileImg() }}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->fullname() }}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ Auth::user()->business_name }}</h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="/{{$type}}/profile">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="/logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

    </ul>
</div>

<script>
  if(!window.readNotification){
      function readNotification(id){
          Livewire.emit('read_notification',id);
      }
  }
</script>
