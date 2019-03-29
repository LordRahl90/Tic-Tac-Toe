<template>
    <div class="container-fluid">
        <div class="navbar">
            <h1>Welcome to Tic-Tac-Toe</h1>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Welcome to Tic-Tac Toe
                </div>
            </div>
            <div class="card-body">
                <p>You Will need to provide your name and character</p>

                <form>
                    <div class="row">
                        <label class="col-md-3">Your Name:</label>
                        <div class="col-md-8">
                            <input type="text" name="Fullname" class="form-control" />
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-md-3">Your Character:</label>
                        <div class="col-md-8">
                            <select class="form-control">
                                <option selected disabled>Select Character</option>
                                <option value="x">X</option>
                                <option value="o">O</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <button class="btn btn-primary">Proceed</button>
                        <button class="btn btn-light">Clear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data:function(){
            return{};
        },
        methods:{

        }
    }
</script>

<style scoped>
    .row{
        margin-bottom: 10px;
    }
</style>