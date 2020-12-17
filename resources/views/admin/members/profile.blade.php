@extends('layouts.app_new', ['prev_button' =>
    ['name' => __('Members'), 'href' => route('admin.members.index')]
])

@section('content')
    <div class="data tabs-wrap col-12">
        <div class="data-bg">
            <div class="edit-member">
                <div class="member-info">
                    <div class="member-data">
                        <div class="member-img">
                            <img src="{{ $member->avatar ?? asset('images/default-user.png') }}" alt="">
                        </div>
                        <div class="text">
                            <div class="name">
                                <p>{{ $member->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="member-status">
                        <div class="status-name">
                            <p>Client balance</p>
                        </div>
                        <div class="status-condition">
                            <p>
                                <i class="icon-wallet"></i>{{ $member->balance }} <i class="icon-plus"></i><span>credits</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="member-fields">
                    <div class="add-new">
                        <div class="row">
                            <div class="item col-lg-4 col-md-6 col-sm-12">
                                <label class="text-option">
                                    <span class="label-wrap">
                                        <input type="text" value="{{ $member->name }}"
                                               class="placeholder-effect">
                                        <span class="placeholder">Name</span>
                                    </span>
                                </label>
                            </div>
                            <div class="item col-lg-4 col-md-6 col-sm-12">
                                <label class="text-option">
                                    <span class="label-wrap">
                                        <input type="email" value="{{ $member->email }}"
                                               class="placeholder-effect">
                                        <span class="placeholder">E-mail</span>
                                    </span>
                                </label>
                            </div>
                            <div class="item col-lg-4 col-md-6 col-sm-12">
                                <label class="text-option">
                                    <span class="label-wrap">
                                        <input type="tel" value="{{ $member->phone }}"
                                               class="placeholder-effect">
                                        <span class="placeholder">Phone</span>
                                    </span>
                                </label>
                            </div>

                            <div class="item col-lg-4 col-md-6 col-sm-12">
                                <label class="text-option">
                                    <span class="label-wrap">
                                        <input type="password" value="******" readonly
                                               class="placeholder-effect">
                                        <span class="placeholder">Password</span>
                                    </span>
                                </label>
                            </div>
                            <div class="item col-lg-4 col-md-6 col-sm-12">
                                <button class="main-btn yellow-blank" id="send-reset-link">Send link for reset password</button>
                            </div>
                            <div class="item col-lg-4 col-md-6 col-sm-12">
                                <label class="text-option">
                                    <span class="label-wrap">
                                        <input type="text" value="{{ $member->id }}" class="placeholder-effect">
                                        <span class="placeholder">User ID</span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="member-switcher">
                        <p>Member status:</p>
                        <label class="switcher-wrap">
                            <input type="checkbox" {{ $member->status ? 'checked' : '' }}>
                            <span class="switcher-condition">
                                <span class="option">Block</span>
                                <span class="active-side"></span>
                                <span class="option">Active</span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="data tabs-wrap col-12">
        <div class="table-intro">
            <div class="tabs-menu">
                <div class="touch-scroll">
                    <div class="scroll-wrap">
                        <ul>
                            <li class="open" data-index="1"><a href="javascript:void(0)">Booking
                                    history</a></li>
                            <li data-index="2"><a href="javascript:void(0)">Transaction history</a></li>
                            <li data-index="3"><a href="javascript:void(0)">Tickets history</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <label class="select-date">
                <span class="name">Date:</span>
                <input type="text" placeholder="Select date">
                <span class="icon-calendar"></span>
            </label>
        </div>
        <div class="data-bg">
            <div class="tabs-content open" data-index="1">
                <div class="table-wrap">
                    <table>
                        <thead>
                        <tr>
                            <td>Office name</td>
                            <td>Time duration</td>
                            <td>Book price</td>
                            <td>Date</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($member->bookings as $booking)
                            <tr>
                                <td><b>{{ $booking->room->name }}</b></td>
                                <td>{{ $booking->start_date->format('H:i') }}
                                    - {{ $booking->end_date->format('H:i') }}</td>
                                <td>{{ $booking->price }} credits</td>
                                <td>{{ $booking->start_date->format('Y-m-d') == $booking->end_date->format('Y-m-d') ? $booking->start_date->format('d.m.Y') : $booking->start_date->format('d.m.Y') . ' - ' . $booking->end_date->format('d.m.Y') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tabs-content" data-index="2">
                <div class="table-wrap">
                    <table>
                        <thead>
                        <tr>
                            <td>Transaction ID</td>
                            <td>Date</td>
                            <td>Mode</td>
                            <td>Amount</td>
                            <td>Status</td>
                            <td>Invoice</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($member->transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->created_at ? $transaction->created_at->format('d.m.Y H:i') : '' }}</td>
                                <td>{{ $transaction->payment_method ? $transaction->payment_method->mode : '' }}</td>
                                <td>{{ $transaction->price }}</td>
                                <td>
                                    <div class="status">
                                        @if($transaction->status == \App\Models\Transaction::STATUS_PENDING)
                                            <p style="background: #FF5260;">Pending</p>
                                        @else
                                            <p style="background: #27AE60;">Paid</p>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="download-link"><span
                                            class="icon-download"></span></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tabs-content" data-index="3">
                <div class="table-wrap">
                    <table>
                        <thead>
                        <tr>
                            <td>Ticket ID</td>
                            <td>TDate</td>
                            <td>Last message</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($member->support_tickets as $support_tickets)
                            <tr>
                                <td><b>Ticket {{ $support_tickets->id }}</b></td>
                                <td>{{ $support_tickets->updated_at->format('d.m.Y') }}</td>
                                <td><span class="one-line">{{ $support_tickets->last_message }}</span>
                                </td>
                                <td>
                                    <button type="button" class="main-btn gray-blank">Open</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    @include('admin.members.modal')
@endpush
@push('scripts')
    <script>
        $('#send-reset-link').click(function (){
            $.ajax({
                url: '{{ route('admin.members.reset-link', $member->id) }}',
                type: 'POST',
                success: function () {
                    alert("{{ __('Sent') }}")
                },
                error: function () {
                    alert("{{ __('Something went wrong.') }}")
                }
            });
        })
    </script>
@endpush
