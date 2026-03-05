<template>
  <div class="rich-text-editor">
    <div class="editor-toolbar" v-if="editor">
      <!-- Text formatting -->
      <div class="toolbar-group">
        <button type="button" @click="editor.chain().focus().toggleBold().run()"
          :class="{ 'is-active': editor.isActive('bold') }" title="Bold">
          <i class="icon-bold2"></i>
        </button>
        <button type="button" @click="editor.chain().focus().toggleItalic().run()"
          :class="{ 'is-active': editor.isActive('italic') }" title="Italic">
          <i class="icon-italic2"></i>
        </button>
        <button type="button" @click="editor.chain().focus().toggleUnderline().run()"
          :class="{ 'is-active': editor.isActive('underline') }" title="Underline">
          <i class="icon-underline2"></i>
        </button>
        <button type="button" @click="editor.chain().focus().toggleStrike().run()"
          :class="{ 'is-active': editor.isActive('strike') }" title="Strikethrough">
          <i class="icon-strikethrough2"></i>
        </button>
        <button type="button" @click="editor.chain().focus().toggleHighlight().run()"
          :class="{ 'is-active': editor.isActive('highlight') }" title="Highlight">
          <i class="icon-paint-format"></i>
        </button>
      </div>

      <div class="toolbar-divider"></div>

      <!-- Headings -->
      <div class="toolbar-group">
        <select class="editor-select" @change="setHeading($event.target.value); $event.target.value = currentHeading"
          :value="currentHeading">
          <option value="paragraph">Paragraph</option>
          <option value="1">Heading 1</option>
          <option value="2">Heading 2</option>
          <option value="3">Heading 3</option>
          <option value="4">Heading 4</option>
        </select>
      </div>

      <div class="toolbar-divider"></div>

      <!-- Text alignment -->
      <div class="toolbar-group">
        <button type="button" @click="editor.chain().focus().setTextAlign('left').run()"
          :class="{ 'is-active': editor.isActive({ textAlign: 'left' }) }" title="Align left">
          <i class="icon-paragraph-left3"></i>
        </button>
        <button type="button" @click="editor.chain().focus().setTextAlign('center').run()"
          :class="{ 'is-active': editor.isActive({ textAlign: 'center' }) }" title="Align center">
          <i class="icon-paragraph-center3"></i>
        </button>
        <button type="button" @click="editor.chain().focus().setTextAlign('right').run()"
          :class="{ 'is-active': editor.isActive({ textAlign: 'right' }) }" title="Align right">
          <i class="icon-paragraph-right3"></i>
        </button>
        <button type="button" @click="editor.chain().focus().setTextAlign('justify').run()"
          :class="{ 'is-active': editor.isActive({ textAlign: 'justify' }) }" title="Justify">
          <i class="icon-paragraph-justify3"></i>
        </button>
      </div>

      <div class="toolbar-divider"></div>

      <!-- Lists -->
      <div class="toolbar-group">
        <button type="button" @click="editor.chain().focus().toggleBulletList().run()"
          :class="{ 'is-active': editor.isActive('bulletList') }" title="Bullet list">
          <i class="icon-list-unordered"></i>
        </button>
        <button type="button" @click="editor.chain().focus().toggleOrderedList().run()"
          :class="{ 'is-active': editor.isActive('orderedList') }" title="Ordered list">
          <i class="icon-list-ordered"></i>
        </button>
        <button type="button" @click="editor.chain().focus().toggleBlockquote().run()"
          :class="{ 'is-active': editor.isActive('blockquote') }" title="Blockquote">
          <i class="icon-quotes-left"></i>
        </button>
        <button type="button" @click="editor.chain().focus().setHorizontalRule().run()" title="Horizontal rule">
          <i class="icon-minus3"></i>
        </button>
      </div>

      <div class="toolbar-divider"></div>

      <!-- Insert -->
      <div class="toolbar-group">
        <button type="button" @click="addLink" :class="{ 'is-active': editor.isActive('link') }" title="Insert link">
          <i class="icon-link"></i>
        </button>
        <button type="button" v-if="editor.isActive('link')" @click="editor.chain().focus().unsetLink().run()"
          title="Remove link">
          <i class="icon-unlink"></i>
        </button>
        <button type="button" @click="triggerImageUpload" title="Insert image">
          <i class="icon-image2"></i>
        </button>
        <button type="button" @click="addYoutube" title="Embed YouTube">
          <i class="icon-play3"></i>
        </button>
      </div>

      <div class="toolbar-divider"></div>

      <!-- Table -->
      <div class="toolbar-group">
        <button type="button" @click="insertTable" title="Insert table"
          :class="{ 'is-active': editor.isActive('table') }">
          <i class="icon-table2"></i>
        </button>
        <template v-if="editor.isActive('table')">
          <button type="button" @click="editor.chain().focus().addColumnBefore().run()" title="Add column before">
            <i class="icon-arrow-left12"></i><i class="icon-grid52" style="font-size: 0.7em;"></i>
          </button>
          <button type="button" @click="editor.chain().focus().addColumnAfter().run()" title="Add column after">
            <i class="icon-grid52" style="font-size: 0.7em;"></i><i class="icon-arrow-right13"></i>
          </button>
          <button type="button" @click="editor.chain().focus().addRowBefore().run()" title="Add row before">
            <i class="icon-arrow-up12"></i>
          </button>
          <button type="button" @click="editor.chain().focus().addRowAfter().run()" title="Add row after">
            <i class="icon-arrow-down12"></i>
          </button>
          <button type="button" @click="editor.chain().focus().deleteColumn().run()" title="Delete column">
            <i class="icon-cross3" style="color: #d33;"></i>
          </button>
          <button type="button" @click="editor.chain().focus().deleteRow().run()" title="Delete row">
            <i class="icon-cross3" style="color: #d33;"></i>
          </button>
          <button type="button" @click="editor.chain().focus().deleteTable().run()" title="Delete table">
            <i class="icon-bin" style="color: #d33;"></i>
          </button>
        </template>
      </div>

      <div class="toolbar-divider"></div>

      <!-- History -->
      <div class="toolbar-group">
        <button type="button" @click="editor.chain().focus().undo().run()" :disabled="!editor.can().undo()"
          title="Undo">
          <i class="icon-undo2"></i>
        </button>
        <button type="button" @click="editor.chain().focus().redo().run()" :disabled="!editor.can().redo()"
          title="Redo">
          <i class="icon-redo2"></i>
        </button>
      </div>

      <div class="toolbar-divider"></div>

      <!-- Code -->
      <div class="toolbar-group">
        <button type="button" @click="editor.chain().focus().toggleCode().run()"
          :class="{ 'is-active': editor.isActive('code') }" title="Inline code">
          <i class="icon-embed2"></i>
        </button>
        <button type="button" @click="editor.chain().focus().toggleCodeBlock().run()"
          :class="{ 'is-active': editor.isActive('codeBlock') }" title="Code block">
          <i class="icon-file-text2"></i>
        </button>
      </div>
    </div>

    <div class="editor-content-wrapper">
      <editor-content :editor="editor" class="editor-content-area" />

      <div v-if="isUploading" class="editor-upload-overlay">
        <div class="upload-progress-box">
          <div class="upload-spinner"></div>
          <div class="upload-text">{{ uploadStatusText }}</div>
          <div class="upload-progress-bar">
            <div class="upload-progress-fill" :style="{ width: uploadPercent + '%' }"></div>
          </div>
        </div>
      </div>
    </div>

    <input type="file" ref="imageInput" @change="handleImagePick" accept="image/*" style="display: none;" />
  </div>
</template>

<script>
import { Editor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import { Table } from '@tiptap/extension-table';
import { TableRow } from '@tiptap/extension-table-row';
import { TableCell } from '@tiptap/extension-table-cell';
import { TableHeader } from '@tiptap/extension-table-header';
import { Youtube } from '@tiptap/extension-youtube';
import { Image } from '@tiptap/extension-image';
import { Link } from '@tiptap/extension-link';
import { TextAlign } from '@tiptap/extension-text-align';
import { Underline } from '@tiptap/extension-underline';
import { Placeholder } from '@tiptap/extension-placeholder';
import { Color } from '@tiptap/extension-color';
import { TextStyle } from '@tiptap/extension-text-style';
import { Highlight } from '@tiptap/extension-highlight';
import axios from 'axios';

/**
 * Strip Microsoft Word / Office HTML junk from pasted content.
 * Removes XML namespaces, conditional comments, base64 images, and excessive inline styles.
 */
function cleanWordHtml(html) {
  let cleaned = html;

  cleaned = cleaned.replace(/<!--\[if[^>]*>[\s\S]*?<!\[endif\]-->/gi, '');
  cleaned = cleaned.replace(/<!--[\s\S]*?-->/g, '');
  cleaned = cleaned.replace(/<\/?\w+:[^>]*>/gi, '');
  cleaned = cleaned.replace(/<\?xml[\s\S]*?\?>/gi, '');
  cleaned = cleaned.replace(/<style[\s\S]*?<\/style>/gi, '');
  cleaned = cleaned.replace(/<meta[^>]*>/gi, '');
  cleaned = cleaned.replace(/<link[^>]*>/gi, '');
  cleaned = cleaned.replace(/<img[^>]+src\s*=\s*["']data:image\/[^"']*["'][^>]*>/gi, '');
  cleaned = cleaned.replace(/\s*class\s*=\s*["'][^"']*Mso[^"']*["']/gi, '');
  cleaned = cleaned.replace(/\s*style\s*=\s*["'][^"']*mso-[^"']*["']/gi, '');
  cleaned = cleaned.replace(/<span[^>]*>\s*(&nbsp;)?\s*<\/span>/gi, '');
  cleaned = cleaned.replace(/<p[^>]*>\s*(&nbsp;)?\s*<\/p>/gi, '');

  return cleaned;
}

const pendingImageStore = new Map();

export default {
  name: 'RichTextEditor',
  components: {
    EditorContent,
  },
  props: {
    modelValue: {
      type: String,
      default: '',
    },
    placeholder: {
      type: String,
      default: 'Mulai menulis...',
    },
    uploadUrl: {
      type: String,
      default: 'editor/upload-image',
    },
    imageFolder: {
      type: String,
      default: '',
    },
  },
  emits: ['update:modelValue'],
  data() {
    return {
      editor: null,
      isUploading: false,
      uploadStatusText: '',
      uploadPercent: 0,
    };
  },
  computed: {
    currentHeading() {
      if (!this.editor) return 'paragraph';
      for (let level = 1; level <= 4; level++) {
        if (this.editor.isActive('heading', { level })) return String(level);
      }
      return 'paragraph';
    },
  },
  watch: {
    modelValue(value) {
      if (!this.editor) return;
      const isSame = this.editor.getHTML() === value;
      if (isSame) return;
      this.editor.commands.setContent(value, false);
    },
  },
  mounted() {
    const vm = this;

    this.editor = new Editor({
      content: this.modelValue,
      editorProps: {
        transformPastedHTML(html) {
          return cleanWordHtml(html);
        },
        handleDrop(view, event) {
          const files = event.dataTransfer?.files;
          if (!files || files.length === 0) return false;

          const imageFile = Array.from(files).find(f => f.type.startsWith('image/'));
          if (!imageFile) return false;

          event.preventDefault();
          vm.insertLocalImage(imageFile);
          return true;
        },
        handlePaste(view, event) {
          const items = event.clipboardData?.items;
          if (!items) return false;

          for (const item of items) {
            if (item.type.startsWith('image/')) {
              event.preventDefault();
              const file = item.getAsFile();
              if (file) vm.insertLocalImage(file);
              return true;
            }
          }
          return false;
        },
      },
      extensions: [
        StarterKit.configure({
          heading: { levels: [1, 2, 3, 4] },
          link: false,
          underline: false,
        }),
        Table.configure({ resizable: true }),
        TableRow,
        TableCell,
        TableHeader,
        Youtube.configure({
          inline: false,
          ccLanguage: 'id',
        }),
        Image.configure({
          inline: false,
          allowBase64: false,
          HTMLAttributes: {
            class: 'editor-image',
          },
        }),
        Link.configure({
          openOnClick: false,
          HTMLAttributes: {
            rel: 'noopener noreferrer',
            target: '_blank',
          },
        }),
        TextAlign.configure({
          types: ['heading', 'paragraph'],
        }),
        Underline,
        Placeholder.configure({
          placeholder: this.placeholder,
        }),
        TextStyle,
        Color,
        Highlight,
      ],
      onUpdate: ({ editor }) => {
        this.$emit('update:modelValue', editor.getHTML());
      },
    });
  },
  beforeUnmount() {
    if (this.editor) {
      this.editor.destroy();
    }
  },
  methods: {
    setHeading(value) {
      if (value === 'paragraph') {
        this.editor.chain().focus().setParagraph().run();
      } else {
        this.editor.chain().focus().toggleHeading({ level: parseInt(value) }).run();
      }
    },
    addLink() {
      const previousUrl = this.editor.getAttributes('link').href;
      const url = window.prompt('URL:', previousUrl);
      if (url === null) return;
      if (url === '') {
        this.editor.chain().focus().extendMarkRange('link').unsetLink().run();
        return;
      }
      this.editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
    },
    addYoutube() {
      const url = window.prompt('YouTube URL:');
      if (!url) return;
      this.editor.commands.setYoutubeVideo({
        src: url,
        width: 640,
        height: 360,
      });
    },
    insertTable() {
      this.editor.chain().focus().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run();
    },
    triggerImageUpload() {
      this.$refs.imageInput.click();
    },

    /**
     * Insert a local blob URL preview for the given File.
     * Nothing is uploaded yet — that happens in prepareForSave().
     */
    insertLocalImage(file) {
      const blobUrl = URL.createObjectURL(file);
      pendingImageStore.set(blobUrl, file);
      this.editor.chain().focus().setImage({ src: blobUrl }).run();
    },

    handleImagePick(event) {
      const file = event.target.files[0];
      if (!file) return;
      this.insertLocalImage(file);
      event.target.value = '';
    },

    /**
     * Upload all pending (blob URL) images to the server and replace
     * blob URLs with real server URLs in the editor content.
     * Call this before form submission.
     *
     * @returns {Promise<string>} Final HTML with all images uploaded
     * @throws {Error} If any image upload fails (so we never save blob URLs)
     */
    async prepareForSave(onProgress) {
      const total = pendingImageStore.size;

      if (total > 0) {
        this.isUploading = true;
        this.uploadPercent = 0;
        this.uploadStatusText = 'Mempersiapkan upload gambar...';

        const replacements = new Map();
        const errors = [];
        let done = 0;

        for (const [blobUrl, file] of pendingImageStore.entries()) {
          done++;
          this.uploadStatusText = 'Mengunggah gambar ' + done + ' dari ' + total + '...';
          this.uploadPercent = Math.round(((done - 1) / total) * 100);
          if (typeof onProgress === 'function') {
            onProgress({ current: done, total });
          }

          const formData = new FormData();
          formData.append('image', file);
          if (this.imageFolder) {
            formData.append('folder', this.imageFolder);
          }

          try {
            const response = await axios.post('/api/' + this.uploadUrl, formData);
            const url = response.data?.url;
            if (!url) {
              throw new Error('Server did not return image URL');
            }
            replacements.set(blobUrl, url);
            this.uploadPercent = Math.round((done / total) * 100);
          } catch (error) {
            console.error('Image upload error:', error);
            errors.push(file.name);
          }
        }

        if (errors.length > 0) {
          this.isUploading = false;
          for (const blobUrl of pendingImageStore.keys()) {
            URL.revokeObjectURL(blobUrl);
          }
          pendingImageStore.clear();
          throw new Error('Gagal mengunggah ' + errors.length + ' gambar: ' + errors.join(', ') + '. Silakan coba lagi.');
        }

        this.uploadStatusText = 'Memproses konten...';

        let html = this.editor.getHTML();
        for (const [blobUrl, serverUrl] of replacements.entries()) {
          html = html.split(blobUrl).join(serverUrl);
          URL.revokeObjectURL(blobUrl);
          pendingImageStore.delete(blobUrl);
        }

        this.editor.commands.setContent(html, false);
        this.$emit('update:modelValue', html);
        this.isUploading = false;
      }

      let finalHtml = this.editor.getHTML();
      if (/blob:https?:\/\//i.test(finalHtml)) {
        finalHtml = finalHtml.replace(/<img[^>]*src="blob:[^"]*"[^>]*>/gi, '');
        this.editor.commands.setContent(finalHtml, false);
        this.$emit('update:modelValue', finalHtml);
      }

      return finalHtml;
    },
  },
};
</script>

<style>
.rich-text-editor {
  border: 1px solid #ddd;
  border-radius: 4px;
  background: #fff;
}

.editor-toolbar {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 2px;
  padding: 6px 8px;
  border-bottom: 1px solid #ddd;
  background: #f8f9fa;
}

.toolbar-group {
  display: flex;
  align-items: center;
  gap: 1px;
}

.toolbar-divider {
  width: 1px;
  height: 24px;
  background: #ddd;
  margin: 0 4px;
}

.editor-toolbar button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  padding: 0;
  border: 1px solid transparent;
  border-radius: 3px;
  background: transparent;
  color: #555;
  cursor: pointer;
  font-size: 14px;
  transition: all 0.15s ease;
}

.editor-toolbar button:hover {
  background: #e9ecef;
  border-color: #ddd;
  color: #333;
}

.editor-toolbar button.is-active {
  background: #d0e3ff;
  border-color: #a0c4ff;
  color: #1a73e8;
}

.editor-toolbar button:disabled {
  opacity: 0.4;
  cursor: not-allowed;
}

.editor-select {
  height: 32px;
  padding: 2px 8px;
  border: 1px solid #ddd;
  border-radius: 3px;
  background: #fff;
  font-size: 13px;
  color: #555;
  cursor: pointer;
}

.editor-select:hover {
  border-color: #aaa;
}

.editor-content-area .tiptap {
  padding: 16px 20px;
  min-height: 400px;
  outline: none;
  font-size: 15px;
  line-height: 1.7;
  color: #333;
}

.editor-content-area .tiptap p.is-editor-empty:first-child::before {
  content: attr(data-placeholder);
  float: left;
  color: #adb5bd;
  pointer-events: none;
  height: 0;
}

/* Headings */
.editor-content-area .tiptap h1 { font-size: 2em; font-weight: 700; margin: 1em 0 0.5em; }
.editor-content-area .tiptap h2 { font-size: 1.6em; font-weight: 700; margin: 0.8em 0 0.4em; }
.editor-content-area .tiptap h3 { font-size: 1.3em; font-weight: 600; margin: 0.6em 0 0.3em; }
.editor-content-area .tiptap h4 { font-size: 1.1em; font-weight: 600; margin: 0.5em 0 0.3em; }

/* Lists */
.editor-content-area .tiptap ul,
.editor-content-area .tiptap ol {
  padding-left: 1.5em;
  margin: 0.5em 0;
}

.editor-content-area .tiptap ul { list-style-type: disc; }
.editor-content-area .tiptap ol { list-style-type: decimal; }

.editor-content-area .tiptap li { margin: 0.2em 0; }

/* Blockquote */
.editor-content-area .tiptap blockquote {
  border-left: 4px solid #1a73e8;
  padding: 8px 16px;
  margin: 1em 0;
  background: #f0f4ff;
  color: #555;
  font-style: italic;
}

/* Horizontal rule */
.editor-content-area .tiptap hr {
  border: none;
  border-top: 2px solid #eee;
  margin: 1.5em 0;
}

/* Code */
.editor-content-area .tiptap code {
  background: #f0f0f0;
  padding: 2px 6px;
  border-radius: 3px;
  font-family: 'Fira Code', 'Consolas', monospace;
  font-size: 0.9em;
  color: #d63384;
}

.editor-content-area .tiptap pre {
  background: #1e1e1e;
  color: #d4d4d4;
  padding: 16px;
  border-radius: 6px;
  overflow-x: auto;
  margin: 1em 0;
}

.editor-content-area .tiptap pre code {
  background: none;
  color: inherit;
  padding: 0;
  font-size: 0.9em;
}

/* Images */
.editor-content-area .tiptap img.editor-image {
  max-width: 100%;
  height: auto;
  border-radius: 4px;
  margin: 1em 0;
  cursor: pointer;
}

.editor-content-area .tiptap img.ProseMirror-selectednode {
  outline: 3px solid #1a73e8;
}

/* Links */
.editor-content-area .tiptap a {
  color: #1a73e8;
  text-decoration: underline;
  cursor: pointer;
}

/* Tables */
.editor-content-area .tiptap table {
  border-collapse: collapse;
  table-layout: fixed;
  width: 100%;
  margin: 1em 0;
  overflow: hidden;
}

.editor-content-area .tiptap table td,
.editor-content-area .tiptap table th {
  min-width: 80px;
  border: 1px solid #ddd;
  padding: 8px 12px;
  vertical-align: top;
  position: relative;
}

.editor-content-area .tiptap table th {
  background: #f0f0f0;
  font-weight: 600;
  text-align: left;
}

.editor-content-area .tiptap table .selectedCell::after {
  content: "";
  position: absolute;
  left: 0; right: 0; top: 0; bottom: 0;
  background: rgba(26, 115, 232, 0.1);
  pointer-events: none;
}

.editor-content-area .tiptap table .column-resize-handle {
  position: absolute;
  right: -2px;
  top: 0;
  bottom: -2px;
  width: 4px;
  background: #1a73e8;
  pointer-events: none;
}

/* YouTube embed */
.editor-content-area .tiptap div[data-youtube-video] {
  margin: 1em 0;
}

.editor-content-area .tiptap div[data-youtube-video] iframe {
  max-width: 100%;
  border-radius: 6px;
}

/* Highlight */
.editor-content-area .tiptap mark {
  background: #fff3cd;
  padding: 1px 2px;
  border-radius: 2px;
}

/* Table resize cursor */
.editor-content-area .tiptap .tableWrapper {
  overflow-x: auto;
  margin: 1em 0;
}

.editor-content-area .tiptap .resize-cursor {
  cursor: col-resize;
}

.editor-content-wrapper {
  position: relative;
}

.editor-upload-overlay {
  position: absolute;
  inset: 0;
  background: rgba(255, 255, 255, 0.88);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 10;
  border-radius: 0 0 4px 4px;
}

.upload-progress-box {
  text-align: center;
  padding: 24px 32px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.12);
  min-width: 260px;
}

.upload-spinner {
  width: 36px;
  height: 36px;
  border: 3px solid #e9ecef;
  border-top-color: #1a73e8;
  border-radius: 50%;
  animation: editor-spin 0.7s linear infinite;
  margin: 0 auto 12px;
}

@keyframes editor-spin {
  to { transform: rotate(360deg); }
}

.upload-text {
  font-size: 14px;
  color: #555;
  margin-bottom: 12px;
}

.upload-progress-bar {
  height: 6px;
  background: #e9ecef;
  border-radius: 3px;
  overflow: hidden;
}

.upload-progress-fill {
  height: 100%;
  background: #1a73e8;
  border-radius: 3px;
  transition: width 0.3s ease;
}
</style>
