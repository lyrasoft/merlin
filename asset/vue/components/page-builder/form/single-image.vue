<template>
  <div class="c-single-image-uploader">
    <div class="form-group c-single-image-preview text-center" v-if="url !== '' && !uploading">
      <img :src="previewUrl" alt="Image" class="img-fluid rounded" style="max-height: 450px;">
    </div>

    <div class="c-single-image-placeholder text-center p-4 mb-3 border rounded" v-if="url === '' && !uploading">
      <small class="text-muted">拖拉圖片</small>
    </div>

    <div class="form-group d-flex align-items-center" v-if="uploading" style="min-height: 450px;">
      <img :src="loadingImage" class="mx-auto" alt="Loading">
    </div>

    <div class="form-group">
      <div class="input-group">
        <input :id="id"
          type="text"
          v-model="url"
          class="form-control"
          :disabled="uploading"
          @paste="pasteFile"
        />
        <div class="input-group-append">
          <button type="button" class="btn btn-primary" @click="chooseFile()"
            :disabled="uploading">
            上傳圖片
          </button>
          <button type="button" class="btn btn-primary" @click="pasteFromButton()"
            :disabled="uploading"
            v-b-tooltip
            title="貼上">
            <span class="fa fa-paste"></span>
          </button>
          <button v-if="url !== ''" type="button" class="btn btn-primary" @click="url = ''"
            :disabled="uploading">
            <span class="fa fa-times"></span>
          </button>
        </div>
      </div>
      <small class="form-text text-muted">
        貼上圖片網址，或者上傳圖片，也可以將本地端圖片拖拉至此。
      </small>
    </div>
  </div>
</template>

<script>
export default {
  name: "single-image",
  data() {
    return {
      url: '',
      loadingImage: Phoenix.route('loading_image'),
      uploading: false
    };
  },
  props: {
    value: String,
    id: String,
    accepted: {
      type: Array,
      default() {
        return [
          'image/jpeg',
          'image/png',
          'image/gif',
          'image/webp',
        ];
      }
    }
  },
  created() {
    this.url = this.value;
  },
  mounted() {
    const $el = $(this.$el);

    $el.on('dragover', (event) => {
      event.stopPropagation();
      event.preventDefault();
      $el.addClass('c-single-image-uploader--hover');
    });

    $el.on('dragleave', (event) => {
      event.stopPropagation();
      event.preventDefault();
      $el.removeClass('c-single-image-uploader--hover');
    });

    // File drop
    $el.on("drop", (event) => {
      event.stopPropagation();
      event.preventDefault();

      $el.removeClass('c-single-image-uploader--hover');

      const files = event.originalEvent.target.files || event.originalEvent.dataTransfer.files;

      this.uploadFile(files[0]);
    });
  },
  methods: {
    chooseFile() {
      const input = $('<input type="file">');

      input.on('change', event => {
        const files = event.originalEvent.target.files || event.originalEvent.dataTransfer.files;

        this.uploadFile(files[0])
      });

      input.click();
    },

    pasteFromButton() {
      navigator.clipboard.read().then((items) => {
        const type = items[0].types[1];

        items[0].getType(type).then((blob) => {
          this.uploadFile(blob);
        });
      });
    },

    pasteFile(event) {
      if (event.clipboardData.items[1] && event.clipboardData.items[1].kind === 'file') {
        event.preventDefault();
        event.stopPropagation();

        const item = event.clipboardData.items[1];

        if (!item) {
          console.error('No paste item');
          return;
        }
        console.log(item, item.getAsFile());
        this.uploadFile(item.getAsFile());
      }
    },

    uploadFile(file) {
      if (!this.checkFile(file)) {
        return;
      }

      const formData = new FormData();
      formData.append('file', file);

      this.uploading = true;

      $.post({
        url: Phoenix.route('single_image_upload'),
        data: formData,
        processData: false,
        contentType: false
      })
        .done((res) => {
          let url = res.data.url;
          
          if (url.indexOf(Phoenix.uri('root')) === 0) {
            url = url.substr(Phoenix.uri('root').length + 1);
          }
          
          this.url = url;
        })
        .fail((xhr) => {
          console.error(xhr.responseJSON.message);
          alert(xhr.responseJSON.message);
        })
        .always(() => {
          this.uploading = false;
        });
    },

    checkFile(file) {
      if (this.accepted.indexOf(file.type) < 0) {
        alert('不允許的格式');
        return false;
      }

      return true;
    }
  },
  watch: {
    value() {
      this.url = this.value;
    },
    url() {
      this.$emit('change', this.url);
      this.$emit('input', this.url);
    }
  },
  computed: {
    previewUrl() {
      let url = this.url;

      if (!url) {
        return url;
      }

      if (url.indexOf('http') !== 0 && url.indexOf('/') !== 0) {
        return Phoenix.uri('root') + '/' + url;
      }

      return url;
    }
  }
}
</script>

<style scoped>

</style>
