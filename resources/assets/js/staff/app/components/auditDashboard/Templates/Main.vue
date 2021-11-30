<template>
    <div class="content">
        <div class="row mt-2 pl-lg-5 pr-lg-5 pt-lg-5">
            <div class="col-12">
                <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
                    <div class="block-content block-content-full tab-content">
                        <div class="h3 text-center">WELCOME TO THE KNOWLEDGE STORE</div><br>
                        <div class="p text-center">This is a great place to come 'knowledge shopping'. Just <strong>click on a folder</strong> below and open the file template you want to work on.</div><br>
                        <div class="p text-center">DONT FORGET TO CHOOSE <strong>'SAVE AS'</strong> and upload your completed template in the <strong>Upload Files</strong> section</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pl-lg-5 pr-lg-5 pt-lg-2">
            <div class="col-12">
                <groups/>
            </div>
        </div>
    </div>
</template>
<script>
import Groups from "./Groups";

export default {
    components: {
        Groups,
    }    
}
</script>