@extends('layout.app')

@section('content')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="m-0">Send WhatsApp Message</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('send-whatsapp-message') }}" enctype="multipart/form-data">
                        @csrf
                        @include('auth.message')
                        <div class="mb-3">
                            <label class="form-label" for="inputPhone">Phone:</label>
                            <input
                                type="text"
                                name="phone"
                                id="inputPhone"
                                class="form-control @error('phone') is-invalid @enderror"
                                placeholder="Phone Number"
                                value="{{ old('phone') }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputMessage">Message:</label>
                            <textarea
                                name="message"
                                id="inputMessage"
                                class="form-control @error('message') is-invalid @enderror"
                                placeholder="Enter Message">{{ old('message') }}</textarea>
                            @error('message')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputFile">File:</label>
                            <input
                                type="file"
                                name="file"
                                id="inputFile"
                                class="form-control @error('file') is-invalid @enderror">
                            @error('file')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success btn-submit">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-6 justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h2 class="m-0">WhatsApp Message History</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>File</th>
                                    <th>Sent At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($messages as $message)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $message->whatsapp_nomor }}</td>
                                        <td>{{ $message->whatsapp_pesan }}</td>
                                        <td>
                                            @if ($message->whatsapp_file)
                                                <a href="{{ asset('wa_file/' . $message->whatsapp_file) }}" target="_blank">View File</a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $message->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="card-footer clearfix">
                            {{ $messages->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
