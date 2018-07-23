@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
    @include('partials.title', [
        'fa' => 'fa-info-circle',
        'title' => 'Privacy',
        'link' => route('pages.privacy')
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
                <h6 class="border-bottom border-gray pb-2 mb-0">
                    Privacy Policy
                </h6>
                <p class="text-muted small lh-135 pt-3">We at {{ config('job-core.domain') }} know that you care how your information is used, and we appreciate your trust. This notice describes our privacy policy. By visiting us, you are accepting the privacy policy described below.</p>
                <h6>What Personal Information Do We Collect?</h6>
                <p class="text-muted small lh-135"><strong>Information You Provide.</strong> We receive and store information you enter. For example, when you search for something, or leave a comment, or when you supply information such as your address, phone number or e-mail address. You can choose not to provide certain information, but then you might not be able to take advantage of some of our features. We use the information that you provide for such purposes as responding to your requests, customizing your experience, improving our Web site, and communicating with you.</p>
                <p class="text-muted small lh-135"><strong>Cookies.</strong> Like many web sites, we use "cookies". Cookies are small programs that we transfer to your hard drive that allow us to recognize you and to provide you with a customized experience. If you do not want us to use cookies, you can easily disable them by going to the toolbar of your web browser, and clicking on the "help" button. Follow the instructions that will prevent the browser from accepting cookies, or set the browser to inform you when you receive a new cookie. In addition, you may visit this and other websites anonymously through the use of utilities provided by other private companies.</p>
                <p class="text-muted small lh-135">Third party vendors, including Google, use cookies to serve ads based on a user's prior visits to our website. Google's use of the DoubleClick cookie enables it and its partners to serve ads to our users based on their visit to our sites and/or other sites on the Internet. Users may opt out of the use of the DoubleClick cookie for interest-based advertising by visiting the ads preference manager. (Alternatively, they can opt out of a third-party vendor's use of cookies for interest based advertising by visiting aboutads.info.)</p>
                <p class="text-muted small lh-135"><strong>Other Information:</strong> Every computer has an IP (Internet Protocol) address. IP addresses of computers used to visit this site are noted. In addition, we automatically collect other information such as email addresses, browser types, operating systems, and the URL addresses of sites clicked to and from this site.</p>
            </div>
            <div class="col-12 col-md-3">
            </div>
        </div>
    </div>
@endsection