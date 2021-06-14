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
                            <img src="{{ $member->avatar ? $member->avatar_url : asset('images/default-user.png') }}"
                                 alt="">
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
                                <i class="icon-wallet"></i>
                                <code id="current-balance">{{ $member->balance }}</code>
                                <a href="javascript:void(0);" class="main-btn yellow">{{__('Edit')}}</a>
                                <span>credits</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="member-fields">
                    <div class="add-new">
                        <form method="POST" action="{{ route('admin.members.update', $member->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="item col-lg-4 col-md-6 col-sm-12">
                                    <label class="text-option">
                                    <span class="label-wrap">
                                        <input type="text" name="name" value="{{ old('name', $member->name) }}"
                                               class="placeholder-effect">
                                        <span class="placeholder">Name</span>
                                    </span>
                                        @error('name')
                                        <div class="profile-error-text">{{ $message }}</div>
                                        @enderror
                                    </label>
                                </div>
                                <div class="item col-lg-4 col-md-6 col-sm-12">
                                    <label class="text-option">
                                    <span class="label-wrap">
                                        <input type="email" name="email" value="{{ old('email', $member->email) }}"
                                               class="placeholder-effect">
                                        <span class="placeholder">E-mail</span>
                                    </span>
                                        @error('email')
                                        <div class="profile-error-text">{{ $message }}</div>
                                        @enderror
                                    </label>
                                </div>
                                <div class="item col-lg-4 col-md-6 col-sm-12">
                                    <label class="text-option">
                                    <span class="label-wrap">
                                        <input type="tel" name="phone" value="{{ old('phone', $member->phone) }}"
                                               class="placeholder-effect">
                                        <span class="placeholder">Phone</span>
                                    </span>
                                        @error('phone')
                                        <div class="profile-error-text">{{ $message }}</div>
                                        @enderror
                                    </label>
                                </div>

                                <div class="item col-lg-4 col-md-6 col-sm-12">
                                    <label class="text-option">
                                    <span class="label-wrap">
                                        <input type="password" value="" class="placeholder-effect" name="password">
                                        <span class="placeholder">Password</span>
                                    </span>
                                    </label>
                                </div>
                                <div class="item col-lg-4 col-md-6 col-sm-12">
                                    <button type="button" class="main-btn yellow-blank" id="send-reset-link">
                                        {{ __('Send link for reset password') }}
                                    </button>
                                </div>
                                <div class="item col-lg-4 col-md-6 col-sm-12">
                                    <label class="text-option">
                                    <span class="label-wrap">
                                        <input type="text" value="{{ $member->id }}" class="placeholder-effect"
                                               readonly disabled>
                                        <span class="placeholder">User ID</span>
                                    </span>
                                    </label>
                                </div>
                                <div class="item col-lg-4 col-md-6 col-sm-12">
                                    <label class="text-option">
                                <span class="label-wrap">
                                <span class="select">
                                    <select class="placeholder-effect" name="company_id" id="company_id">
                                        <option {{ old('company_id', $member->company_id) ? '' : 'selected' }}> </option>
                                        @foreach($companies as $key => $value)
                                            <option
                                                value="{{ $key }}" {{ old('company_id', $member->company_id) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <span class="placeholder">{{ __('Company') }}</span>
                                </span>
                                </span>
                                        @error('company_id')
                                        <div class="profile-error-text">{{ $message }}</div>
                                        @enderror
                                    </label>
                                </div>
                            </div>
                            <button class="main-btn yellow">Save</button>
                        </form>
                    </div>
                    <div class="member-switcher">
                        <p>Member status:</p>
                        <label class="switcher-wrap">
                            <input type="checkbox" id="user-status" {{ $member->status ? 'checked' : '' }}>
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
                                <td>{{ $booking->start_date->timezone('Asia/Jerusalem')->format('H:i') }}
                                    - {{ $booking->end_date->timezone('Asia/Jerusalem')->format('H:i') }}</td>
                                <td>{{ $booking->price }} credits</td>
                                <td>{{ $booking->start_date->format('Y-m-d') == $booking->end_date->format('Y-m-d')
                                    ? $booking->start_date->timezone('Asia/Jerusalem')->format('d.m.Y')
                                    : $booking->start_date->timezone('Asia/Jerusalem')->format('d.m.Y') . ' - ' . $booking->end_date->timezone('Asia/Jerusalem')->format('d.m.Y') }}</td>
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
                            <td>Description</td>
                            <td>Status</td>
                            <td>Invoice</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($member->transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->created_at ? $transaction->created_at->format('d.m.Y H:i') : '' }}</td>
                                <!--<td>{{ $transaction->payment_method ? $transaction->payment_method->mode : '' }}</td>-->
                                <td>{{ $transaction->type }}</td>

                                <td>{{ $transaction->credit }}</td>
                                <!-- <td>{{ $transaction->price }}</td> -->
                                <td><div style = "width:80px; word-wrap: break-word">{!! $transaction->description !!}</div></td>
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
        $('#send-reset-link').click(function () {
            let _this = $(this);
            _this.attr('disabled', true);
            $.ajax({
                url: '{{ route('admin.members.reset-link', $member->id) }}',
                type: 'POST',
                success: function (res) {
                    alert(res.success ? "{{ __('Sent') }}" : "{{ __('Not Sent') }}")
                },
                error: function () {
                    alert("{{ __('Something went wrong.') }}")
                },
                complete: function () {
                    _this.removeAttr('disabled');
                }
            });
        });

        $('#user-status').click(function () {
            let state = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route('admin.members.change-status', $member->id) }}',
                type: 'POST',
                data: {
                    status: state
                },
                error: function () {
                    alert("{{ __('Something went wrong.') }}");
                    $(this).prop('checked', !state);
                }
            });
        });

        $('.status-condition .main-btn').click(function () {
            $.fancybox.open({
                src: '#balance-modal',
                afterClose: function () {
                    $('#balance-modal input[name="credits"]').val('')
                }
            });
        });

        // $(document).on('input', 'input[name="credits"]', function () {
        //     if ($(this).val()) {
        //         if ($(this).val() < 0) $(this).val(0)
        //         $(this).val(+$(this).val())
        //     }
        // });

        $(document).on('click', '.add-credits', function () {
            let creditsToAdd = $('#balance-modal input[name="credits"]').val();
            let transectionDescription= $('#balance-modal textarea[name="transectionDescription"]').val();
            console.log(transectionDescription);
            if(creditsToAdd==""){
               alert('Credit value cannot be Empty');
            }else if(transectionDescription=="" || transectionDescription==undefined){
               alert("Please Provide the Description");
            }else{
            $.ajax({
                url: '{{ route('admin.members.add-credits', $member->id) }}',
                type: 'POST',
                data: {
                    credits: creditsToAdd,
                    description: transectionDescription
                },
                success: function (data) {
                    $('#current-balance').text(data.balance)
                    $('#balance-modal textarea[name="transectionDescription"]').val("");
                },
                error: function () {
                    alert("{{ __('Something went wrong.') }}")
                },
                complete: function () {
                    $.fancybox.close({src: '#balance-modal'});
                }
            });
            }
        });
    </script>
@endpush
