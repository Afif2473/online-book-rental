@extends('layout')

@section('content')
<div class="container-fluid" style="background-color: #f8fafc; min-height: 100vh;">
    <div class="row pt-4 px-3">
        
        <!-- 1. Include your Sidebar on the Left (takes up 3 columns) -->
        @include('layouts.navigation')

        <!-- 2. Create the Main Content Area on the Right (takes up the remaining 9 columns) -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </main>

    </div>
</div>
@endsection