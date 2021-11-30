 <template>
    <div class="bg-image" style="background-image: url('/media/photos/photo22@2x.jpg')">
        <div class="hero bg-white-95">
            <div class="hero-inner">
                <div class="content content-full">
                    <div class="px-3 py-5 text-center">
                       <div class="display-1 text-muted font-w700">503</div>
                       <h1 class="h2 font-w700 mt-5 mb-3">Oops.. You just found an error page..</h1>
                       <h2 class="h3 font-w400 text-muted mb-5">We are sorry but our service is currently not available..</h2>
                        <div class="invisible" data-toggle="appear" data-class="animated fadeInUp" data-timeout="600">
                           <router-link class="btn btn-hero-secondary" to="/">
                              <i class="fa fa-arrow-left mr-1"></i> Take me home
                           </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
   data: function () {
      return {
      }
   },
   methods: {
      //
   }
}
</script>
