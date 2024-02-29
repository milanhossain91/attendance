<table id="" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center" style="display: none">
                <label class="pos-rel">
                    <input type="checkbox" class="ace" />
                    <span class="lbl"></span>
                </label>
            </th>
            <th>No</th>
            <th>Department Name</th>
            <th class="hidden-480">Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
    @if(!empty($departments))
        @foreach($departments as $department)
            <tr class="item{{$department->id}}">
                <td class="center" style="display: none">
                    <label class="pos-rel">
                        <input type="checkbox" class="ace" />
                        <span class="lbl"></span>
                    </label>
                </td>

                <td>{{ $loop->iteration }}</td>
                <td id="area_name_{{$department->id}}">{{ucwords($department->dept_name)}}</td>
                <td class="hidden-480">{{$department->status==1 ? 'Active' : 'Inactive'}}</td>

                <td>
                    <div class="hidden-sm hidden-xs action-buttons">
                        <a class="green edit-btn" href="#" data-toggle="modal" data-target="#edit-item"  data-areaid="{{ $department->id }}">
                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                            </button>
                        </a>

                        <a href="#" class="red delete remove-btn" href="#" data-toggle="modal" data-target="#destroy-item" value="{{ $department->id }}">
                            <i class="ace-icon fa fa-trash-o bigger-130"></i>
                        </a>
                    </div>

                    <div class="hidden-md hidden-lg">
                        <div class="inline pos-rel">
                            <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                <li>
                                    <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
                                        <span class="blue">
                                            <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                        </span>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
                                        <span class="green">
                                            <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                        </span>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                                        <span class="red">
                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach

    @endif
    </tbody>
</table>