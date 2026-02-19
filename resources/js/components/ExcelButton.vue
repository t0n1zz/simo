<template>
  <button 
    :class="buttonClass"
    @click="exportToExcel"
    :disabled="disabled"
  >
    <slot>
      <i class="icon-file-download"></i> Download Excel
    </slot>
  </button>
</template>

<script>
import * as XLSX from 'xlsx';

export default {
  props: {
    data: {
      type: Array,
      required: true
    },
    exportFields: {
      type: Object,
      required: true
    },
    name: {
      type: String,
      default: 'export.xlsx'
    },
    title: {
      type: String,
      default: ''
    },
    buttonClass: {
      type: String,
      default: 'btn btn-light'
    },
    disabled: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    exportToExcel() {
      if (!this.data || this.data.length === 0) {
        console.warn('No data to export');
        return;
      }

      // Transform data based on exportFields mapping
      // exportFields format: { "Column Header": "object.property.path" }
      const transformedData = this.data.map(row => {
        const newRow = {};
        Object.keys(this.exportFields).forEach(header => {
          const field = this.exportFields[header];
          newRow[header] = this.getNestedValue(row, field);
        });
        return newRow;
      });

      // Create worksheet
      const ws = XLSX.utils.json_to_sheet(transformedData);
      
      // Auto-size columns
      const cols = [];
      Object.keys(this.exportFields).forEach(header => {
        cols.push({ wch: Math.max(header.length, 15) });
      });
      ws['!cols'] = cols;
      
      // Create workbook
      const wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
      
      // Generate and download file
      XLSX.writeFile(wb, this.name);
    },
    getNestedValue(obj, path) {
      // Handle nested properties like "customer.name" or "product.category.name"
      return path.split('.').reduce((current, prop) => 
        current ? current[prop] : undefined, obj
      );
    }
  }
};
</script>
