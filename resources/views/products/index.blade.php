@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 style="float: left">List of products</h4>
                        <a href="#" style="float: right; text-decoration:none" class="btn btn-dark" data-toggle="modal"
                            data-target="#addProduct">
                            <i class="fa fa-plus"></i> Add new product
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-left">
                            <thead>
                                <th>#</th>
                                <th>Intitulé</th>
                                <th>Marque</th>
                                <th>Prix(Dh)</th>
                                <th>Quantité</th>
                                <th>Stock d'alert</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->brand}}</td>
                                    <td>{{ number_format($product->price,2)}}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>
                                        @if ($product->alert_stock >= $product->quantity)
                                            <span class="badge badge-danger"> stock < {{$product->alert_stock}}</span>

                                        @else <span class="badge badge-success">{{$product->alert_stock}}</span>
                                            
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" data-toggle="modal" data-target="#editProduct{{ $product->id }}"
                                                class="btn btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="#" data-toggle="modal" data-target="#deleteProduct{{ $product->id }}"
                                                class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal pour modifier un produit -->
                                <div class="modal right fade" id="editProduct{{ $product->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel">Mise à jour</h4>
                                                <button type="button" class="btn-close" data-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('products.update', $product->id) }}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Intitulé</label>
                                                        <input type="text" name="product_name"
                                                            value="{{ $product->product_name }}" class="form-control" id="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Marque</label>
                                                        <input type="text" name="brand" value="{{ $product->brand }}"
                                                            class="form-control" id="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Prix</label>
                                                        <input type="text" name="price" value="{{ $product->price }}"
                                                            class="form-control" id="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Quantité</label>
                                                        <input type="number" name="quantity" value="{{ $product->quantity }}"
                                                            class="form-control" id="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Stock d'alert</label>
                                                        <input type="number" name="alert_stock" value="{{ $product->alert_stock }}"
                                                            class="form-control" id="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Description</label>
                                                        <textarea name="description" class="form-control" aria-label="With textarea">{{$product->description}}</textarea>
                                                    </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-warning btn-block">Modifier</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                    </div>

                    <!-- Modal pour confirmer la suppression un produit -->
                    <div class="modal  fade" id="deleteProduct{{ $product->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabel">Suppression</h4>
                                    <button type="button" class="btn-close" data-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <p style="text-align: center; font-size:15px;">
                                            Voulez-vous supprimer définitivement
                                            le produit <span style="font-weight: bolder">{{ $product->product_name }} </span> de
                                            la base données ?
                                        </p>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                            &nbsp;&nbsp;&nbsp;
                                            <button type="submit" class="btn btn-danger">Supprimer</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
                    {{-- Pagination ---}}
                    {{$products->links()}}
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4> Search product</h4>
                </div>
                <div class="card-body">
                    ----
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Modal pour ajouter un produit -->
    <div class="modal right fade" id="addProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Ajout d'un produit</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Intitulé</label>
                            <input type="text" name="product_name" class="form-control" id=""
                                >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Marque</label>
                            <input type="text" name="brand" class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Prix</label>
                            <input type="text" name="price" class="form-control" id=""
                                >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Quantité</label>
                            <input type="number" name="quantity" class="form-control" id=""
                                placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Stock d'alert</label>
                            <input type="number" name="alert_stock" value="10" class="form-control" id=""
                                placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="rol">Description</label>
                            <textarea name="description" class="form-control" aria-label="With textarea"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-block">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .modal.right .modal-dialog {
            top: 0;
            right: 0;
            margin-right: 0;
            margin-top: 0;
            width: 320px;
        }

        modal.fade:not(.in).right .modal-dialog {
            -webkit-transform: translate3d(25%, 0, 0);
            transform: matrix3d(25%, 0, 0);
            margin-right: 20vh;
        }

    </style>

@endsection
