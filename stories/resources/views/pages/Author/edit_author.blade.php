@extends('layouts.DefaultLayout')
@section('content')

    <form method="POST" action={{route('author.update')}}>
        @csrf
        <input type="text" value="{{ $data->id }}" hidden name="id">
        <div class="grid grid-cols-1 gap-4">
            <div class="flex flex-col">
                <label class="text-[16px] text-gray-500 my-4" for="name">Add author:</label>
                <input class="py-2 px-4 w-full text-[16px] text-gray-500 outline-blue-500 border-[#ddd] border-2" type="text" name="name" id="name" placeholder="Please name author..." value="{{$data->name}}">
                <button class="bg-blue-500 text-white text-[17px] text-center py-2 rounded-[10px] mt-10">Add author</button>
            </div>
        </div>
    </form>
@endsection

@push('js')

<script>
   
    @if (Session::has('message'))
    toastr.success("{{ Session::get('message') }}") 
    @endif
</script>
@endpush