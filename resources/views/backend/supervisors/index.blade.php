@extends('layouts.admin')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="ml-auto">
                <a href="{{ route('admin.supervisors.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">إضافة مشرف جديد</span>
                </a>
            </div>
        </div>

        @include('backend.supervisors.filter.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>الصورة</th>
                    <th>الاسم</th>
                    <th>الموبايل & الايميل</th>
                    <th>الحالة</th>
                    <th> التاريخ</th>
                    <th class="text-center" style="width: 30px;">لوحة التحكم</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            @if ($user->user_image != '')
                                <img src="{{ asset('assets/users/' . $user->user_image) }}" width="60">
                            @else
                                <img src="{{ asset('assets/users/default.jpg') }}" width="60">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.supervisors.show', $user->id) }}">{{ $user->name }}</a>
                            <p class="text-gray-400"><b>{{ $user->username }}</b></p>
                        </td>
                        <td>
                            {{ $user->email }}
                            <p class="text-gray-400"><b>{{ $user->mobile }}</b></p>
                        </td>
                        <td>{{ $user->status() }}</td>
                        <td>{{ $user->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.supervisors.edit', $user->id) }}"
                                 class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="javascript:void(0)" onclick="if (confirm('هل أنت متأكد من حذف هذا المشرف؟') ) { document.getElementById('supervisor-delete-{{ $user->id }}').submit(); } else { return false; }" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                <form action="{{ route('admin.supervisors.destroy', $user->id) }}"
                                 method="post" id="supervisor-delete-{{ $user->id }}"
                                  style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">لا يوجد مشرفون  </td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="6">
                        <div class="float-right">
                            {!! $users->appends(request()->input())->links() !!}
                        </div>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

@endsection
