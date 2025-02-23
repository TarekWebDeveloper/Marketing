<div class="card-body">
    {!! Form::open(['route' => 'admin.contact_us.index', 'method' => 'get']) !!}
    
    <div class="row">


        <div class="col-2">
            <div class="form-group">
                {!! Form::text('keyword', old('keyword', request()->input('keyword')), 
                ['class' => 'form-control', 'placeholder' => 'البحث هنا  ']) !!}
            </div>
        </div>


        <div class="col-2">
            <div class="form-group">
                {!! Form::select('status', ['' => '---', '1' => 'تمت القراءة', '0' => 'جديد'],

                 old('status', request()->input('status')), 

                ['class' => 'form-control']) !!}
            </div>
        
        </div>


        <div class="col-2">
            <div class="form-group">
                {!! Form::select('sort_by', ['' => '---', 'name' => 'الاسم', 'title' => 'العنوان', 

                'created_at' => ' التاريخ'], old('sort_by', request()->input('sort_by')),

                ['class' => 'form-control']) !!}

            </div>
        </div>


        <div class="col-2">
            <div class="form-group">
                {!! Form::select('order_by', ['' => '---', 'asc' => 'تصاعدي', 'desc' => 'تنازلي'],

                     old('order_by', request()->input('order_by')),

                 ['class' => 'form-control']) !!}
            </div>
        </div>


        <div class="col-1">
            <div class="form-group">
                {!! Form::select('limit_by', ['' => '---', '10' => '10', '20' => '20', '50' => '50'], 
                    
                    old('limit_by', request()->input('limit_by')),

                 ['class' => 'form-control']) !!}
            </div>
        </div>


        <div class="col-1">
            <div class="form-group">
                {!! Form::button('البحث', ['class' => 'btn btn-link', 'type' => 'submit']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
