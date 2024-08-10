@extends('layouts.app', ['page' => __('Create Users'), 'pageSlug' => 'create users'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Create User</h5>
            </div>
            <form method="post" action="{{route('create.new.users')}}" autocomplete="off">
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label>Hash ID</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                <i class="tim-icons icon-single-02"></i>
                            </div>          
                        </div>
                        <input type="text" name="hash_id" class="form-control" placeholder="Name" value="{{$hash_id}}" style="pointer-events: none;">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>          
                            </div>
                            <input type="text" name="password" class="form-control" placeholder="enter password" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Role select</label>
                        <select class="form-control" id="role" name="role">
                            @if(Auth::user()->hasRole('admin'))
                            <option value="client">Client</option>
                            <option value="agent">Agent</option>
                            <option value="market">Market</option>
                            @elseif(Auth::user()->hasRole('agent'))
                            <option value="market">Market</option>
                            @endif
                        </select>
                    </div>
                    
                        <div class="form-group">
                            <label>Details for top up</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>          
                                </div>
                                <input type="text" name="details_from" class="form-control" placeholder="enter details for top up" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Details for withdrawal </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>          
                                </div>
                                <input type="text" name="details_to" class="form-control" placeholder="enter details for withdrawal" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Balance</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>          
                                </div>
                                <input type="text" name="balance" class="form-control" placeholder="enter if need balance">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Percent</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>          
                                </div>
                                <input type="text" name="percent" class="form-control" placeholder="enter percent" requiredd>
                            </div>
                        </div>

                        <div class="form-group" id="market" >
                            <label for="exampleFormControlSelect1">Agent select</label>
                            <select class="form-control" name="agent_id">
                                @foreach($agents as $agent)
                                    <option value="{{$agent->hash_id}}">{{$agent->hash_id}}</option>
                                @endforeach
                            </select>
                        </div>

                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-fill btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const role = document.getElementById('role');
        const market = document.getElementById('market');

        role.addEventListener('change', function(){
            const selectedRole = role.value;

            market.style.display = 'none';

            // Показываем секцию в зависимости от выбранной роли
            if (selectedRole === 'client') {
                market.style.display = 'none';
            } else if (selectedRole === 'market') {
                market.style.display = 'block';
            } else if (selectedRole === 'agent') {
                market.style.display = 'none';
            }
        });

        role.dispatchEvent(new Event('change'))
    })
</script>

@endsection