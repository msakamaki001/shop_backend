@extends('layouts.app')

@section('content')
<div class="container-fluid">
   <div class="">
       <div class="mx-auto" style="max-width:1200px">
           <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">商品一覧</h1>
           <div class="">
               <div class="d-flex flex-row flex-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">商品名</th>
                                <th scope="col">値段</th>
                                <th scope="col">数量</th>
                                <th scope="col">カテゴリ名</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td scope="row">{{$item->id}}</td>
                                <td scope="row">{{$item->item_name}}</td>
                                <td scope="row">{{$item->price}}円</td>
                                <td scope="row">{{$item->num}}個</td>
                                <td scope="row">{{$item->category_name}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
               </div>
               {{$items->links('vendor.pagination.bootstrap-4')}}
           </div>
       </div>
   </div>
</div>
@endsection