<template>
<!-- eslint-disable -->
    <div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"
                v-if="results.current_page > 1 "
                @click.prevent="$emit('get-page',1 )"
                >
                    <a href="#" class="page-link" >
                        <i class="fas fa-chevron-left"></i>
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>

                <li class="page-item"
                v-if="results.current_page > 1"
                @click.prevent="$emit('get-page', results.current_page-1)"
                >
                    <a href="#" class="page-link" >
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>

                <!-- Before Numbers -->
                    <li class="page-item"
                    v-if="results.current_page > 1">
                        <span class="page-link">...</span>
                    </li>

                    <li class="page-item"
                        v-for="num in results.last_page"
                        @click.prevent="$emit('get-page',num)"
                        v-if="num > results.current_page - 5 && num < results.current_page + 5 "
                        :class="{active: num === results.current_page}"
                    >
                        <a href="" class="page-link">{{num}}</a>
                    </li>
                    
                    <li class="page-item"
                        v-if="results.current_page < results.last_page"
                    >
                        <span class="page-link">...</span>
                    </li>

                <!-- After Numbers -->

                <li class="page-item"
                 v-if="results.current_page < results.last_page"
                @click.prevent="$emit('get-page', results.current_page+1)"
                >
                    <a href="#" class="page-link">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>

                 <li class="page-item" 
                 v-if="results.current_page < results.last_page "
                 @click.prevent="$emit('get-page',results.last_page)">
                    <a href="#" class="page-link">
                        <i class="fas fa-chevron-right"></i>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>
<script>
    export default{
        mounted() {
            console.log(this.results)
        },
        props: ['results']

    }
</script>