@extends('layouts.DefaultLayout')
@section('content')

<div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <table class="min-w-full text-center text-sm font-light">
            <thead
              class="border-b bg-blue-500 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
              <tr>
                <th scope="col" class=" px-6 py-4">#</th>
                <th scope="col" class=" px-6 py-4">Name</th>
                <th scope="col" class=" px-6 py-4">Edit</th>
                <th scope="col" class=" px-6 py-4">Delete</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-b dark:border-neutral-500">
                @foreach ($data as $index => $each )
                <tr>
                    <td class="whitespace-nowrap  px-6 py-4 font-medium">{{ $index + 1 }}</td>
                    <td class="whitespace-nowrap  px-6 py-4">{{$each->name}}</td>
                    <td class="whitespace-nowrap  px-6 py-4 text-orange-500"><a href={{route('category.edit', $each)}}>Edit</a></td>
                    <td class="whitespace-nowrap  px-6 py-4 text-red-700"><a href="/">Delete</a></td>
                </tr>
            @endforeach
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
    <form method="POST" action={{route('category.store')}}>
        @csrf
        <div class="grid grid-cols-1 gap-4">
            <div class="flex flex-col">
                <label class="text-[16px] text-gray-500 my-4" for="name">Add category:</label>
                <input class="py-2 px-4 w-full text-[16px] text-gray-500 outline-blue-500 border-[#ddd] border-2" type="text" name="name" id="name" placeholder="Please name category..." >
                <div class="mt-10">
                  @foreach ($errors->all() as $error)
                    <p class="text-[16px] text-red-500">{{ $error }}</p>
                  @endforeach
                </div>
                <button class="bg-blue-500 text-white text-[17px] text-center py-2 rounded-[10px] mt-10">Add category</button>
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