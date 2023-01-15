<x-app-layout page-title="Contact Us">
    @section('css')
        <link rel="stylesheet" href="{{ asset('assets/css/client/contact.css') }}">
    @endsection
        <div class="container py-9">
            <div class="row">
                <div class="col-lg-12 text-center pb-6">
                    <h1 class="fw-600 h4">Send Us A Message</h1>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-8 mx-auto">
                    <form>
                        <div class="row">
                            <div class="form-group col-6" data-validate="Type first name">
                                <label class="mb-1" for="first-name">First name</label>
                                <input id="first-name" class="form-control" type="text" name="first-name" placeholder="First name">
                            </div>
                            <div class="form-group col-6"  data-validate="Type last name">
                                <label class="mb-1" for="first-name">Last name</label>
                                <input  class="form-control"  type="text" name="last-name" placeholder="Last name">
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="mb-1" for="email">Email </label>
                            <input id="email"  class="form-control"  type="text" name="email" placeholder="Eg. example@email.com">
                        </div>
                        <div class="form-group">
                            <label class="mb-1" for="phone">Subject</label>
                            <input id="subject"  class="form-control"  type="text" name="subject" >
                        </div>
                        <div class="form-group" data-validate="Message is required">
                            <label class="mb-1" for="message">Message *</label>
                            <textarea id="message"  class="form-control"  name="message" placeholder="Write us a message"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</x-app-layout>
