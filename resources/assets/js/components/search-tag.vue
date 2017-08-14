<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
           <h3>Search for a new album tag: <small v-text="term"></small></h3>
            <form>
                <div class="form-group">
                    <label for="album-tag">Tag</label>
                    <input type="text" class="form-control" v-model="term" :placeholder="term">
                </div>
                <button type="submit" class="btn btn-default">Search</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },

        data() {
            return {
                term: 'hello world',
            }
        }
    }
</script>
