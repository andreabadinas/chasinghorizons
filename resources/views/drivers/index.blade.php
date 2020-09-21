@extends('layouts.layout')
@section('content')

<div class="container">
    <br><br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <br><br>
            <div class="card">
                <div class="card-header modal-title text-secondary"><h5>Drivers</h5></div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr style="text-align: center;">
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                           
                            
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count($drivers); $i++) 
                
                                <tr class="product-item" >
                                    <td>{{ $drivers[$i]->id}}</td>
                                    <td>{{ $drivers[$i]->name}}</td>
                                    <td>{{$drivers[$i]->email}}</td>
                                
                                <td>
                                <form action="{{ route('drivers.destroy', $drivers[$i]->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger float-right" onclick="return confirm('Sure Want Delete?')">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </form> 

                                    <a class="btn btn-light btn-link float-right" href="{{ route('drivers.show', $drivers[$i]->id) }}">details</a>   
                                </td>
                            
                            </tr>
                            @endfor
                        </tbody>
                        </table>
                    </div>
                    <a class="btn btn-light" href="/main">back to admin</a>
                </div>

                </div>    
            </div>
        </div>
    </div>
</div>





                        
    
@endsection