<template>
    <div class="results">
        <ul>
            <template v-for="img in tagImgs">
                 <img :src="img.src" alt="">
            </template>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['taggedImgs'],
        computed: {
            tagImgs: function() {
                return this.taggedImgs.map((img) => {
                    return {
                        src: _.get(img, 'images.standard_resolution.url', ''),
                    }
                });

            },
        }
    }
</script>
