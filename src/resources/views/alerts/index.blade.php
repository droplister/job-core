@extends('layouts.app')

@section('title', str_singular(config('job-core.keyword')) . ' Alerts')

@section('content')
    <div class="alert alert-warning mt-3 box-shadow">
        <i class="fa fa-bell"></i> Job Alerts - Coming Soon!
    </div>
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-md-9">
                <h6 class="border-bottom border-gray pb-2 mb-0">Resources</h6>  
                <p class="text-muted small lh-135 pt-3 mb-0">
                    <a href="https://www.reddit.com/r/SecurityClearance/" target="_blank">
                        <strong>Reddit</strong>
                    </a> - https://www.reddit.com/r/SecurityClearance/
                </p>
                <p class="text-muted small lh-135 pt-2 mb-0">
                    <a href="https://nbib.opm.gov/e-qip-background-investigations" target="_blank">
                        <strong>e-QIP</strong>
                    </a> - Web-based system to facilitate electronic transmission of investigative forms.
                </p>
                <p class="text-muted small lh-135 pt-2 mb-0">
                    <a href="https://www.opm.gov/forms/pdf_fill/sf86-non508.pdf" target="_blank">
                        <strong>SF-86</strong>
                    </a> - Questionnaire for National Security Positions fillable PDF form.
                </p>
                <p class="text-muted small lh-135 pt-2 mb-0">
                    <a href="https://www.opm.gov/forms/pdf_fill/sf85.pdf" target="_blank">
                        <strong>SF-85</strong>
                    </a> - Questionnaire for Non-Sensitive Positions fillable PDF form.
                </p>
                <p class="text-muted small lh-135 pt-2 mb-0">
                    <a href="https://www.opm.gov/forms/pdf_fill/sf85p.pdf" target="_blank">
                        <strong>SF-85P</strong>
                    </a> - Questionnaire for Public Trust Positions fillable PDF form.
                </p>
                <p class="text-muted small lh-135 pt-2 pb-2 mb-0">
                    <a href="http://www.dhra.mil/Portals/52/Documents/perserec/ADR_Version_4.pdf" target="_blank">
                        <strong>Adjudicative Desk Reference</strong>
                    </a> - A comprehensive collection of background information on the 13 categories of behavior considered when determining an individual’s eligibility for a security clearance.
                </p>
                <br class="d-md-none" />
            </div>
            <div class="col-md-3">
                @include('job-core::partials.h-tag', [
                    'tag' => 'h6',
                    'title' => 'Profile',
                ])
                @include('job-core::partials.p-tag', [
                    'text' => $user->name,
                    'pt' => 'pt-3',
                    'pb' => '',
                ])
                @include('job-core::partials.p-tag', [
                    'text' => $user->email,
                    'pt' => '',
                    'pb' => '',
                ])
                @include('job-core::partials.p-tag', [
                    'text' => 'Joined: ' . $user->created_at->toDateString(),
                    'pt' => '',
                    'pb' => 'pb-4',
                ])
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i>
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
@endsection