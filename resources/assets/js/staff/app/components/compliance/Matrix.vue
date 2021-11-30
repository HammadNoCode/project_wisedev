<template>
    <div class="content">
        <div v-if="tab == 'document'">
            <document />
        </div>
        <div v-if="tab == 'training'">
            <training ref="update" />
        </div>
    </div>
</template>
<script>
import Document from "./matrix/Document";
import Training from "./matrix/Training";

export default {
  components: {
    Document,
    Training,
  },
  data: function () {
    return {
      tab: "document",
      edit: false,
      disabled: false,
    };
  },
};
</script>
