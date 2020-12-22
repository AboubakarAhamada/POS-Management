@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 style="float: left">List of users</h4>
                        <a href="#" style="float: right; text-decoration:none" class="btn btn-dark" data-toggle="modal"
                            data-target="#addUser">
                            <i class="fa fa-plus"></i> Add new user
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-left">
                            <thead>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </thead>
                            {{--Pagination--}}
                            {{$users->links()}}
                            <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->is_admin == 1)
                                            Admin
                                        @else
                                            Caissier
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" data-toggle="modal" data-target="#editUser{{ $user->id }}"
                                                class="btn btn-warning">
                                                <i class="fa fa-edit"></i> Modifier
                                            </a>
                                            <a href="#" data-toggle="modal" data-target="#deleteUser{{$user->id}}" class="btn btn-danger">
                                                <i class="fa fa-trash"> Supprimer</i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal pour modifier un utilisateur -->
                                <div class="modal right fade" id="editUser{{ $user->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel">Mise à jour</h4>
                                                <button type="button" class="btn-close" data-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Nom</label>
                                                        <input type="text" name="name" value="{{ $user->name }}"
                                                            class="form-control" id=""
                                                            placeholder="Entrer le nom de l'utilisateur">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Adresse e-mail</label>
                                                        <input type="email" name="email" value="{{ $user->email }}"
                                                            class="form-control" id="" placeholder="exemple@gmail.com">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="rol">Role (Choisir)</label>
                                                        <select name="is_admin" id="" class="form-control">
                                                            <option value="1" @if ($user->is_admin == 1) selected
                            @endif >Admin</option>
                            <option value="2" @if ($user->is_admin == 2) selected
                                @endif >Caissier</option>
                            </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning btn-block">Modifier</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour confirmer la suppression d'utilisateur -->
    <div class="modal  fade" id="deleteUser{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Suppression</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('delete')
                        <p style="text-align: center; font-size:15px;">
                            Voulez-vous supprimer définitivement
                            l'utilisateur <span style="font-weight: bolder">{{ $user->name }} </span> de la base données ?
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
    </table>
    </div>
    </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h4> Search user</h4>
            </div>
            <div class="card-body">
                ----
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- Modal pour ajouter un utilisateur -->
    <div class="modal right fade" id="addUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Ajout</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nom</label>
                            <input type="text" name="name" class="form-control" id=""
                                placeholder="Entrer le nom de l'utilisateur">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Adresse e-mail</label>
                            <input type="email" name="email" class="form-control" id="" placeholder="exemple@gmail.com">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Mot de passe</label>
                            <input type="password" name="password" class="form-control" id=""
                                placeholder="Entrer le mot de passe">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Confirmer le mot de passe</label>
                            <input type="password" name="confirm_password" class="form-control" id=""
                                placeholder="Entrer à nouveau le mot de passe">
                        </div>
                        <div class="form-group">
                            <label for="rol">Role (Choisir)</label>
                            <select name="is_admin" id="" class="form-control">
                                <option value="1">Admin</option>
                                <option value="2">Caissier</option>
                            </select>
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
