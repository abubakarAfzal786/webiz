@extends('layouts.app')

@section('content')
    <div class="col-md-10 offset-1">
        <div class="card mb-5">
            <div class="card-header">
                {{ __('Customer Service') }}
            </div>
            <div class="card-body">
                <div class="row">
                    @if($justJoined->total())
                        <div class="col-md-6">
                            <h4 class="text-center">Members that joined in the current week</h4>
                            <table class="display table table-striped table-bordered no-footer" role="grid">
                                <thead>
                                <tr role="row">
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>Registered</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($justJoined as $member)
                                    <tr role="row">
                                        <td>{{ $member->id }}</td>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->company->name ?? '' }}</td>
                                        <td>{{ $member->created_at }}</td>
                                        <td>
                                            <div class="action"><a
                                                    href="{{ route('admin.members.profile', $member->id) }}"
                                                    class="btn btn-sm btn-primary">Show</a></div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="float-left">
                                {{ $justJoined->links() }}
                            </div>
                        </div>
                    @endif
                    @if($firstOrders->total())
                        <div class="col-md-6">
                            <h4 class="text-center">Members that have a first order coming up the current week</h4>
                            <div class="table-responsive">
                                <table class="display table table-striped table-bordered no-footer" role="grid">
                                    <thead>
                                    <tr role="row">
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Registered</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($firstOrders as $member)
                                        <tr role="row">
                                            <td>{{ $member->id }}</td>
                                            <td>{{ $member->name }}</td>
                                            <td>{{ $member->company->name ?? '' }}</td>
                                            <td>{{ $member->created_at }}</td>
                                            <td>
                                                <div class="action"><a
                                                        href="{{ route('admin.members.profile', $member->id) }}"
                                                        class="btn btn-sm btn-primary">Show</a></div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="float-right">
                                {{ $firstOrders->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
