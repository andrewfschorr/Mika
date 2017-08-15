<template>
    <div class="results">
        <figure>
                <img src="https://developer.cdn.mozilla.net/media/img/mdn-logo-sm.png" alt="An awesome picture">
            <figcaption>Fig1. MDN Logo!</figcaption>
        </figure>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted!')
            console.log(Mika);
        },
    }
</script>
