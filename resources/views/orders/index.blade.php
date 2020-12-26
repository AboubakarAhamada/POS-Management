@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 style="float: left">Liste des commandes</h4>
                        <a href="#" style="float: right; text-decoration:none" class="btn btn-dark" data-toggle="modal"
                            data-target="#addUser">
                            <i class="fa fa-plus"></i> Nouvelle commande
                        </a>
                    </div>
                    <form action="{{route('orders.store')}}" method="POST">
                        @csrf
                    <div class="card-body">

                        <table class="table table-bordered table-left">
                            <thead>
                                <th>No</th>
                                <th>Produit<span style="color: red"> *</span> </th>
                                <th>Prix unit <span style="color: red"> *</span> </th>
                                <th>Quantité<span style="color: red"> *</span> </th>
                                <th>Dis (%)</span> </th>
                                <th>Total<span style="color: red"> *</span> </th>
                                <th><a href="#" class="btn btn-sm btn-success add_more"> <i class="fa fa-plus"></i></a>
                                </th>
                            </thead>
                            <tbody class="addMoreProduct">

                                <tr>
                                    <td>1</td>
                                    <td>
                                        <select name="product_id[]" id="product_id" class="product_id">
                                            <option value="">Choisir un produit</option>
                                            @foreach ($products as $product)
                                                <option data-price="{{ $product->price }}" value="{{ $product->id }}">
                                                    {{ $product->product_name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" name="price[]" id="price" readonly class="form-control price"></td>
                                    <td><input type="number" name="quantity[]" min="1" value="1" id="quantity"
                                            class="form-control quantity"></td>
                                    <td><input type="text" name="discount[]" id="discount" class="form-control discount">
                                    </td>
                                    <td><input type="text" name="total_amount[]" id="total" readonly class="form-control total_amount"></td>
                                    <td><button class="btn btn-sm btn-secondary"> <i class="fa fa-times"></i></button></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4> Total : <b class="total">0.00</b> </h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="row">
                            <table class="table table-striped">

                                <tr>
                                    <td>
                                        <label for=""><b>Nom du client</b></label>
                                        <div class="">
                                            <input type="text" name="customer_name" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <label for=""><b>Téléphone</b></label>
                                        <div class="">
                                            <input type="tel" name="customer_phone" class="form-control">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                                 <b>Méthode de payement :</b> <br>
                                        <span class="radio-item">
                                            <label class="radio-inline">
                                                <input type="radio" name="payment_method" value="cash" checked>
                                                <i class="fa fa-money-bill text-success"></i> Cash
                                            </label> &nbsp;
                                            <label class="radio-inline"><input type="radio" name="payment_method"
                                                    value="card">
                                                <i class="fa fa-university text-info"></i> Transfert
                                            </label>&nbsp;
                                            <label class="radio-inline"><input type="radio" name="payment_method"
                                                    value="transfert">
                                                <i class="fa fa-credit-card text-danger"></i> Carte de crédit
                                            </label>
                                        </span>
                                    <br>
                                    
                                       <label for=""><b>Payement : </b></label> <input type="text" name="paid_amount" id="paid_amount"
                                            class="form-control"><br><br>
                                       <label for=""><b> Retourné : </b></label>
                                        <input type="text" name="balance" id="balance" readonly class="form-control">
                                    
                                    <br><br>
                                    <button type="submit" class="btn btn-primary btn-block">Enregistrer</button>
                                    <button class="btn btn-danger btn-block"> Calculatrice</button><br><br>
                                    <a href="#" style="text-align: center;color:red;font-size:18px; margin-top:10px"> <i class="fa fa-sign-out-alt"> Log out</i> </a>
                        </div>
                
                    </div>
                </div>
            </div>
        </form>
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

{{-- Scipt pour generer le formulaire d'ajout d'une commande
---}}

@section('script')
    <script>
        /**
                (document).ready(function(){
                    //alert("It works");
                })
                **/
        // Ajout d'une nouvelle commande
        $('.add_more').on('click', function() {
            var product = $('#product_id').html();
            var numberOfRow = ($('.addMoreProduct tr').length - 0) + 1;
            //alert(product)
            var tr = '<tr>' +
                '<td class="no">' + numberOfRow + '</td>' +
                '<td><select class="product_id" name="product_id[]">' + product + '</select></td>' +
                '<td><input type="text" name="price[]" id="price" readonly class="form-control price"></td>' +
                '<td><input type="number" name="quantity[]" min="1" value="1" id="quantity" class="form-control quantity"></td>' +
                '<td><input type="text" name="discount[]" id="discount"class="form-control discount" ></td>' +
                '<td><input type="text" name="total_amount[]" id="total_amount" readonly class="form-control total_amount" ></td>' +
                '<td><button class="btn btn-sm btn-danger delete"> <i class="fa fa-times"></i></button></td>'
            '</tr>';
            $('.addMoreProduct').append(tr);

            // Deleting commande
            /**
            $('.addMoreProduct').delegate('.delete','click', function(){
                $(this).parent().parent().remove();
            })
            **/
            $('.delete').on('click', function() {
                $(this).parent().parent().remove();

                // Puis on apelle la fonction totalAmount pour mettre à jour la somme total
                totalAmount();
            });
        })

        // Cette fonction calcul de la somme total de tous les produits commandés :

        function totalAmount() {
            var total = 0;

            $('.total_amount').each(function() {
                var amount = $(this).val() - 0;
                total += amount;
            });

            $('.total').html(total.toFixed(2));   // 2 chiffres après la virgule
        }

        $('.addMoreProduct').delegate('.product_id', 'change', function() {

            var tr = $(this).parent().parent();
            var price = tr.find('.product_id option:selected').attr('data-price');
            tr.find('.price').val(price);
            var quantity = tr.find('.quantity').val() - 0;
            var price = tr.find('.price').val() - 0;
            var discount = tr.find('.discount').val() - 0;
            var total_amount = (quantity * price) - ((quantity * price * discount) / 100);
            tr.find('.total_amount').val(total_amount.toFixed(2));
            totalAmount();

        })

        $('.addMoreProduct').delegate('.quantity, .discount', 'change', function() {
            var tr = $(this).parent().parent();
            var quantity = tr.find('.quantity').val() - 0;
            var price = tr.find('.price').val() - 0;
            var discount = tr.find('.discount').val() - 0;
            var total_amount = (quantity * price) - ((quantity * price * discount) / 100);
            tr.find('.total_amount').val(total_amount.toFixed(2));
            totalAmount();

        })

        $('#paid_amount').keyup(function(){
            //alert('kkkkk')
            var total = $('.total').html();
            var paid_amount = $(this).val();
            var balance = paid_amount - total;
            $('#balance').val(balance.toFixed(2));

        })

    </script>
@endsection
