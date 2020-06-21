@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>
                        Setting
                        </h2>
                    </div>

                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Attribute</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Password</td>
                                    <td>{{ $user->password }}</td>
                                </tr>
                                
                                 <tr>
                                    <td>Category</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                
                                <tr>
                                    <td>Register At</td>
                                    <td>{{ $user->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                                
                               

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
