<template>
     <div class="results">
        <template v-for="img in tagImgs">
            <figure>
                <img width="200px" :src="img.src" alt="" v-on:click="toggleSelect($event, img.id)">
            </figure>
        </template>
        <div class="filler"></div>
        <div class="filler"></div>
        <div class="filler"></div>
        <div class="filler"></div>
    </div>

    <!-- <div class="results">
        <figure><img width="200px" src="https://scontent.cdninstagram.com/t51.2885-15/s640x640/sh0.08/e35/20214712_324448997981002_4755274746591969280_n.jpg" alt=""></figure><figure><img width="200px" src="https://scontent.cdninstagram.com/t51.2885-15/s640x640/sh0.08/e35/20067316_271079053370575_9095505998549876736_n.jpg" alt=""></figure><figure><img width="200px" src="https://scontent.cdninstagram.com/t51.2885-15/s640x640/sh0.08/e35/20214712_324448997981002_4755274746591969280_n.jpg" alt=""></figure><figure><img width="200px" src="https://scontent.cdninstagram.com/t51.2885-15/s640x640/sh0.08/e35/20067316_271079053370575_9095505998549876736_n.jpg" alt=""></figure><figure><img width="200px" src="https://scontent.cdninstagram.com/t51.2885-15/s640x640/sh0.08/e35/20214712_324448997981002_4755274746591969280_n.jpg" alt=""></figure><figure><img width="200px" src="https://scontent.cdninstagram.com/t51.2885-15/s640x640/sh0.08/e35/20067316_271079053370575_9095505998549876736_n.jpg" alt=""></figure><figure><img width="200px" src="https://scontent.cdninstagram.com/t51.2885-15/s640x640/sh0.08/e35/20214712_324448997981002_4755274746591969280_n.jpg" alt=""></figure><figure><img width="200px" src="https://scontent.cdninstagram.com/t51.2885-15/s640x640/sh0.08/e35/20067316_271079053370575_9095505998549876736_n.jpg" alt=""></figure><figure><img width="200px" src="https://scontent.cdninstagram.com/t51.2885-15/s640x640/sh0.08/e35/20214712_324448997981002_4755274746591969280_n.jpg" alt=""></figure><figure><img width="200px" src="https://scontent.cdninstagram.com/t51.2885-15/s640x640/sh0.08/e35/20067316_271079053370575_9095505998549876736_n.jpg" alt=""></figure>
        <div class="filler"></div>
        <div class="filler"></div>
        <div class="filler"></div>
        <div class="filler"></div>
    </div> -->
</template>

<script>
    export default {
        props: ['taggedImgs'],
        computed: {
            tagImgs: function() {
                return this.taggedImgs.map((img) => {
                    console.log(img);
                    return {
                        src: _.get(img, 'images.standard_resolution.url', ''),
                        id: img.id,
                    }
                });

            },
        },
        methods: {
            toggleSelect(event, id){
                console.log(id);
            }
        },
        data(){
            return {
                selectedImgs: []
            }
        }
    }
</script>
