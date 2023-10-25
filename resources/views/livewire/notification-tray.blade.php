<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="row">
        <div class="col">
            <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li > <a class="dropdown-item" wire:click="getNotifications('all')">All</a></li>
                    <li><a class="dropdown-item" wire:click="getNotifications('unread')">Unread</a></li>
                  </ul>
                </div>

                <div class="header-nav">
                    <h5 class="card-title px-3">Notifications</h5>
                    <ul class="dropdown-menu-end dropdown-menu-arrow notifications">
                        @forelse ($myNotifications as $notification)
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
                        @empty
                          
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    if(!window.readNotification){
        function readNotification(id){
            Livewire.emit('read_notification',id);
        }
    }
</script>
