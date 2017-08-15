<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
           <h3>Search for a new album tag: <small v-text="term"></small></h3>
            <form>
                <div class="form-group">
                    <label for="album-tag">Tag</label>
                    <input ref="tagSearchField" type="text" class="form-control" v-model="term" :placeholder="placeHolder">
                </div>
                <button type="submit" v-on:click="search" class="btn btn-default">Search</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted!')
            console.log(Mika);
        },

        data() {
            return {
                placeHolder: 'enter a tag!',
                term: '',
            }
        },

        methods: {
            search: function(e) {
                e.preventDefault();
                console.log(this.term);
            },
        }
    }
</script>
