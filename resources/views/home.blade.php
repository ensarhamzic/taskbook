@extends('layouts.app')

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .lists a {
        color: black;
    }
</style>
@endsection

@section('content')
<div class="container">



    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header font-weight-bold">
                    <span>Task Lists</span>
                    <i class="fa fa-plus-square-o fa-2x float-right btn py-0 px-2" data-toggle="modal"
                        data-target="#myModal"></i>
                </div>

                <div class="card-body lists" id="listsDiv">
                    @foreach ($user->lists as $list)
                    <a id="list{{ $list['id'] }}" class="d-block" href="javascript:showList({{ $list['id'] }})"
                        oncontextmenu="javascript:deleteModal({{ $list['id'] }})">{{ $list['name'] }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div id="listHeaderDiv" class="card-header text-center">
                    Select a list
                </div>

                <div id="listBodyDiv" class="card-body">
                    <h3 class="text-center my-5">No list selected :&#40;</h3>
                </div>
            </div>
        </div>
    </div>
</div>


















<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Task List</h4>
            </div>
            <div class="modal-body">
                <label for="taskListName">Task List Name</label>
                <input type="text" class="form-control" name="taskListName" id="taskListName">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addList()" data-dismiss="modal">Add</button>
            </div>
        </div>
    </div>
</div>

<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Do you really want to delete this Task List?</h4>
                <input type="hidden" class="form-control" name="taskListNameDel" id="taskListNameDel">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="deleteList()" data-dismiss="modal">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function addList() {
        taskListName = $( "input[name='taskListName']" ).val();
        $.ajax({
            type:'POST',
            url:'/list/add',
            data:{_token: "{{ csrf_token() }}", name: taskListName
            },
            success: function( listName ) {
                $( "input[name='taskListName']" ).val("");
                newList = $("<a></a>");
                newList.attr('href', 'javascript:showList('+listName[1]+')');
                newList.attr('oncontextmenu', 'javascript:deleteModal('+listName[1]+')');
                newList.attr("id", "list"+listName[1]);
                newList.addClass("d-block");
                newList.html(listName[0]);
                $("#listsDiv").append(newList);
            }
        });
    }

    function showList(taskListId) {
        id = taskListId;
        listName = $("#list"+id).html();
        $.ajax({
            type:'POST',
            url:'/list/show',
            data:{_token: "{{ csrf_token() }}", listId: id
            },
            success: function( listContent ) {
                $("#listHeaderDiv").html(listName);
                if(listContent.length != 0) {
                    $("#listBodyDiv").html("");
                    for(i=0;i<listContent.length;i++) {
                        oneTask = $("<a href='#' class='d-block'></a>")
                        oneTask.html(listContent[i]['name']);
                        $("#listBodyDiv").append(oneTask);
                    }
                }
                else {
                    $("#listBodyDiv").html("");
                    $("#listBodyDiv").append("<h3 class='text-center my-5'>No tasks :&#40;</h3>");
                }
            }
        });
    }

    function deleteModal(id){
        $("#deleteModal").modal();
        $("#taskListNameDel").val(id);
        window.event.returnValue = false;
    }

    function deleteList() {
        taskListNameDel = $("#taskListNameDel").val();
        $.ajax({
            type:'POST',
            url:'/list/delete',
            data:{_token: "{{ csrf_token() }}", deleteId: taskListNameDel
            },
            success: function( listId ) {
                $("#list"+listId).remove();
            }
        });
    }
</script>