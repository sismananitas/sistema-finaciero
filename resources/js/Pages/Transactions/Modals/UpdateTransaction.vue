<template>
    <dialog-modal :show="show" @close="close">
        <template #content>
            Contenido
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla illum inventore expedita error maiores libero, fugiat voluptate earum in nam! Ex nemo tempore nobis temporibus illum similique hic eius repellendus!
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Corporis dicta tempora blanditiis velit rerum aut maiores, qui iste, ullam excepturi a laudantium repudiandae dolore, dignissimos laboriosam cumque at consectetur natus.
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur est fugit voluptate quia quam tempore debitis numquam, non inventore cupiditate ad sint minus officia, optio odio iste, quo error assumenda!
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quod fugit expedita ullam sunt labore eaque quaerat eum pariatur magni ducimus saepe esse, maiores quia blanditiis laudantium tempore, reiciendis culpa consequatur.
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur atque neque tenetur deserunt laborum? Nihil aliquam, a officia ipsum vel distinctio ad ut animi placeat voluptatem cumque minus minima totam!
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Praesentium eveniet ab facilis atque nulla rerum, tenetur explicabo, sint deserunt quidem reiciendis sunt eligendi suscipit in nostrum non dolores voluptas quaerat.
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident facere commodi odit explicabo sed deleniti alias cupiditate. Ad eveniet, maxime dolor tempora architecto, debitis quia ab voluptas earum laudantium aperiam.
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores laborum ab minima, aliquam neque voluptatem fuga obcaecati! Veniam, eligendi? Facilis assumenda optio nostrum cumque tenetur corrupti voluptates totam, atque accusantium?
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus voluptas quo omnis quos voluptatum illo rem consequuntur delectus hic assumenda eligendi quaerat laudantium, odit tenetur provident, doloribus esse, similique ducimus.
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, atque a illum beatae dignissimos veritatis exercitationem sapiente natus blanditiis sit cum voluptatibus autem, optio tempora minima deleniti nemo delectus est!
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos quis corrupti sint, architecto velit accusantium, eius explicabo facere, veritatis exercitationem et autem nihil ab tempora rerum minus eligendi aliquam quas?
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim obcaecati cum optio nesciunt perspiciatis sapiente blanditiis id aliquam sunt laboriosam. Saepe odio necessitatibus natus ut quisquam tenetur, veritatis quos ipsa!
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga fugiat inventore qui similique reprehenderit at voluptate. Omnis ex dolores, excepturi, voluptatem temporibus ducimus nesciunt esse autem aspernatur delectus corrupti magnam?
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Mollitia, placeat cupiditate voluptates accusamus ipsum delectus deleniti sunt dolorum, veritatis cumque magni recusandae adipisci nesciunt tempora. Fuga quisquam nesciunt perferendis culpa!
        </template>
    </dialog-modal>
</template>

<script>
import DialogModal from '@/Jetstream/DialogModal'

export default {
    props: ['show'],

    components: {
        DialogModal,
    },

    methods: {
        close() {
            this.$emit('close')
        }
    }
}
</script>