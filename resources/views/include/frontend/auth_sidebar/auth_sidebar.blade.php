<div class="wn__sidebar">
    <aside class="widget recent_widget">
        <ul>
            <li class="list-group-item">
                <img src="{{ asset('assets/users/' . auth()->user()->user_image) }}" alt="{{ auth()->user()->name }}">

            </li>

            <li class="list-group-item"><a href="{{ route('dashboard') }}">منشوراتي</a></li>
            <li class="list-group-item"><a href="{{ route('product.create') }}">منشور جديد</a></li>
            <li class="list-group-item"><a href="{{ route('edit_information') }}"> تحديث المعلومات</a></li>

            <li class="list-group-item"><a href="{{ route('comments') }}">إدارة التعليقات   </a></li>
            <li class="list-group-item"><a href="{{ route('logout') }}"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">الخروج</a></li>
        </ul>
    </aside>
</div>