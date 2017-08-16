<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
           <h3>Search for a new album tag: <small v-text="searchTerm"></small></h3>
            <form>
                <div class="form-group">
                    <label for="album-tag">Tag</label>
                    <input ref="tagSearchField" type="text" class="form-control" v-model="term" :placeholder="placeHolder">
                </div>
                <button type="submit" v-on:click="search" class="btn btn-default">Search</button>
            </form>
            <search-results :taggedImgs="taggedImgs"></search-results>
        </div>
    </div>
</template>

<script>
    import searchResults from './search-results';

    export default {
        components: {
            searchResults: searchResults,
        },

        data() {
            return {
                placeHolder: 'enter a tag!',
                // taggedImgs: [{
                //     id: '25',
                // }],
                taggedImgs:[],
                term: '',
            }
        },

        methods: {
            search: function(e) {
                e.preventDefault();
                if (!this.searchTerm) {
                    return;
                }
                axios.get(`/search-term/${this.searchTerm}`).then(response => {
                    this.taggedImgs = response.data.data;
                }).catch(e => {
                    throw new Error(e);
                })
            },
        },

        computed: {
            searchTerm: function() {
                // remove dashses, spaces, and pounds
                return this.term.replace(/-|\ |#/g, '');
            }
        }
    }
</script>
