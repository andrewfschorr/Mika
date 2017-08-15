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
            <search-results></search-results>
        </div>
    </div>
</template>

<script>
    import searchResults from './search-results';

    export default {
        components: {
            searchResults: searchResults,
        },

        mounted() {
            this.accessToken = Mika.data.accessToken;
        },

        data() {
            return {
                placeHolder: 'enter a tag!',
                term: '',
                accessToken: null,
            }
        },

        methods: {
            search: function(e) {
                e.preventDefault();
                if (!this.searchTerm) {
                    return;
                }
                console.log(this.searchTerm);

               if (!this.accessToken) {
                throw new Error('Access token needed');
               }
                axios.get(`https://api.instagram.com/v1/tags/${this.searchTerm}/media/recent?access_token=${this.accessToken}&callback=cb`).then(response => {
                    // JSON responses are automatically parsed.
                    // console.log(response.data);
                }).catch(e => {
                    this.errors.push(e)
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
