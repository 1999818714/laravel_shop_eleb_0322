@extends('default')

@section('contents')
<table class="table  table-bordered table-striped">
    <tr>
        <th>id</th>
        <th>活动</th>
        <th>商家账号</th>
        <th>操作</th>
    </tr>
    @foreach($eventMembers as $eventMember)
    <tr>
        <td>{{ $eventMember->id }}</td>
        <td>{{ $eventMember->getEvents->title }}</td>
        <td>{{ $eventMember->getUsers->name }}</td>
        <td>
            <a href="{{ route('eventMembers.edit',[$eventMember]) }}" role="button" class="btn btn-primary">编辑</a>
            <a href="{{ route('eventMembers.show',[$eventMember]) }}" role="button" class="btn btn-primary">查看详情</a>
            <form method="post" action="{{ route('eventMembers.destroy',[$eventMember]) }}">
                {{ method_field('DELETE') }}{{--不写这个会报no message--}}
                {{ csrf_field() }}{{--不写这个会报时间那个错误--}}
                <button class="btn btn-danger">删除</button>
            </form>
        </td>
    </tr>
    @endforeach
    <tr>
    </tr>
</table>
    {{ $eventMembers/*->appends(['keyword'=>$keyword])*/->links() }}
@endsection