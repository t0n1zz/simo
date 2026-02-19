/**
 * Filter Helper Functions
 * 
 * Vue 3 removed the filters API. This file provides utility functions
 * to replace the old Vue 2 filters. Import and use these functions
 * directly in your components.
 */

/**
 * Date and Time Filters
 */

export function date(value) {
    if (!value) return '-';
    return window.moment(value).format('DD-MM-YYYY');
}

export function time(value) {
    if (!value) return '-';
    return window.moment(value).format('kk:mm:ss');
}

export function dateTime(value) {
    if (!value) return '-';
    return window.moment(value).format('DD-MM-YYYY') + '&nbsp; | &nbsp;' + window.moment(value).format('kk:mm:ss');
}

export function dateMonth(value) {
    if (!value) return '-';
    return window.moment(value).format('DD MMMM YYYY');
}

export function month(value) {
    if (!value) return '-';
    return window.moment(value).format('MMMM');
}

export function year(value) {
    if (!value) return '-';
    return window.moment(value).format('YYYY');
}

export function relativeHour(value) {
    if (!value) return '-';
    return window.moment(value).fromNow();
}

export function age(dateString) {
    if (!dateString) return '-';
    const today = new Date();
    const birthDate = new Date(dateString);
    let age = today.getFullYear() - birthDate.getFullYear();
    const m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age + ' thn ' + Math.abs(m) + ' bln';
}

export function ageDiff(date1, date2) {
    if (!date1 || !date2) return '-';
    const today = new Date(date1);
    const birthDate = new Date(date2);
    let age = today.getFullYear() - birthDate.getFullYear();
    const m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age + ' thn ' + Math.abs(m) + ' bln';
}

/**
 * String Filters
 */

export function uppercase(value) {
    if (!value) return '';
    return value.charAt(0).toUpperCase() + value.slice(1);
}

export function trimString(string) {
    if (!string) return '';
    return string
        .replace(/<(?:.|\\n)*?>/gm, '')
        .replace(/&nbsp;/g, '')
        .replace(/&ldquo;/g, '')
        .substring(0, 300) + '...';
}

/**
 * Number Filters
 */

export function currency(value, currency = '', decimals = 0, options = {}) {
    if (!value) value = 0;
    if (typeof value === 'string') {
        value = parseFloat(value);
    }

    // Default options for IDR if not specified
    const defaultOptions = {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals,
        style: 'currency',
        currency: 'IDR'
    };

    // Combine defaults with passed options
    const formattingOptions = { ...defaultOptions, ...options };

    // If currency symbol provided manually (old Vue 2 filter style), handle it
    // But Intl.NumberFormat handles currency symbol better

    // For specific separators like thousandsSeparator: "." which is IDR standard:
    // Intl.NumberFormat('id-ID') uses dots for thousands and comma for decimal

    const formatter = new Intl.NumberFormat('id-ID', formattingOptions);
    let formatted = formatter.format(value);

    // If currency arg is provided as prefix string (old filter behavior)
    if (currency) {
        // Strip default IDR prefix if we want to use the custom one, or just append
        // But cleaner to let Intl handle it if possible. 
        // For compatibility with old "Rp." string prefix:
        formatted = formatted.replace('Rp', '').trim();
        return currency + ' ' + formatted;
    }

    return formatted;
}

export function number(value, decimals = 0) {
    if (!value) value = 0;
    if (typeof value === 'string') {
        value = parseFloat(value);
    }
    return new Intl.NumberFormat('id-ID', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
    }).format(value);
}

export function percentage(value, decimals = 0) {
    if (!value) value = 0;
    value = value * 100;
    value = Math.round(value * Math.pow(10, decimals)) / Math.pow(10, decimals);
    return value + '%';
}

export function percentage2(value, decimals = 0) {
    if (!value) value = 0;
    value = value * 100;
    value = Math.round(value * Math.pow(10, decimals)) / Math.pow(10, decimals);
    return value + '%';
}

export function round(value, decimals = 0) {
    if (!value) return 0;
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}

/**
 * Status Filters (return HTML badges)
 */

export function checkStatus(value) {
    if (value > 0) {
        return '<span class="bg-orange-400 text-highlight"><i class="icon-check"></i></span>';
    } else {
        return '<span class="bg-teal-300 text-highlight"><i class="icon-cross3"></i></span>';
    }
}

export function statusDiklat(value) {
    if (value == 1) {
        return '<span class="badge badge-info">MENUNGGU</span>';
    } else if (value == 2) {
        return '<span class="badge badge-warning">PENDAFTARAN BUKA</span>';
    } else if (value == 3) {
        return '<span class="badge badge-secondary">PENDAFTARAN TUTUP</span>';
    } else if (value == 4) {
        return '<span class="badge badge-success"> BERJALAN</span>';
    } else if (value == 5) {
        return '<span class="badge bg-orange-400"> TERLAKSANA</span>';
    } else if (value == 6) {
        return '<span class="badge badge-danger"> BATAL</span>';
    }
    return '';
}

export function statusPeserta(value) {
    if (value == 1) {
        return '<span class="badge badge-info">MENUNGGU</span>';
    } else if (value == 2) {
        return '<span class="badge badge-warning">TERDAFTAR</span>';
    } else if (value == 3) {
        return '<span class="badge badge-secondary">TERDAFTAR</span>';
    } else if (value == 4) {
        return '<span class="badge badge-success">SEDANG MENGIKUTI</span>';
    } else if (value == 5) {
        return '<span class="badge bg-orange-400">SELESAI</span>';
    } else if (value == 6) {
        return '<span class="badge badge-danger">BATAL</span>';
    } else if (value == 7) {
        return '<span class="badge badge-danger">DITOLAK</span>';
    }
    return '';
}

export function statusJalinan(value) {
    if (value == 1) {
        return '<span class="badge badge-warning">CACAT</span>';
    } else if (value == 2) {
        return '<span class="badge badge-danger">MENINGGAL</span>';
    }
    // Note: There are two different statusJalinan filters in the original
    // This one returns HTML badges, the other returns text
    if (value == 0) {
        return 'menunggu';
    } else if (value == 1) {
        return 'dokumen tidak lengkap';
    } else if (value == 2) {
        return 'ditolak';
    } else if (value == 3) {
        return 'disetujui';
    } else if (value == 4) {
        return 'dicairkan';
    } else if (value == 5) {
        return 'selesai';
    }
    return '';
}

export function statusKlaimJalinan(value) {
    if (value == 1) {
        return 'menunggu';
    } else if (value == 2) {
        return 'dokumen tidak lengkap';
    } else if (value == 3) {
        return 'ditolak';
    } else if (value == 4) {
        return 'disetujui';
    } else if (value == 5) {
        return 'dicairkan';
    } else if (value == 6) {
        return 'selesai';
    } else if (value == 7) {
        return 'koreksi';
    } else {
        return 'verifikasi';
    }
}

/**
 * Type/Category Filters
 */

export function checkTingkatAktivis(value) {
    const levels = {
        1: 'Pengurus',
        2: 'Pengawas',
        3: 'Komite',
        4: 'Penasihat',
        5: 'Senior Manajer',
        6: 'Manajer',
        7: 'Supervisor',
        8: 'Staf',
        9: 'Kontrak',
        10: 'Kolektor',
        11: 'Kelompok Inti',
        12: 'Supporting Unit',
        13: 'Vendor sMartCU',
        14: 'Magang'
    };
    return levels[value] || '-';
}

export function kegiatanTipe(value) {
    const types = {
        'diklat_bkcu': 'Diklat PUSKOPCUINA',
        'pertemuan_bkcu': 'Pertemuan PUSKOPCUINA',
        'diklat_bkcu_internal': 'Diklat Internal PUSKOPCUINA',
        'pertemuan_bkcu_internal': 'Pertemuan Internal PUSKOPCUINA',
        'pertemuan_cu_internal': 'Pertemuan Internal CU',
        'diklat_cu_internal': 'Diklat Internal CU',
        'pertemuan_eksternal': 'Pertemuan Eksternal',
        'diklat_eksternal': 'Diklat Eksternal'
    };
    return types[value] || '';
}

export function tipeRekom(value) {
    if (value == 1) {
        return 'Per-Lembaga';
    } else if (value == 2) {
        return 'Per-Peserta';
    } else if (value == 3) {
        return 'PUSKOPCUINA';
    }
    return '';
}

export function tipeProdukCu(value) {
    if (value == 'Simpanan Pokok') {
        return '<span class="badge badge-info">Simpanan Pokok</span>';
    } else if (value == 'Simpanan Wajib') {
        return '<span class="badge badge-warning">Simpanan Wajib</span>';
    } else if (value == 'Simpanan Non Saham') {
        return '<span class="badge badge-secondary">Simpanan Non Saham</span>';
    } else if (value == 'Pinjaman Kapitalisasi') {
        return '<span class="badge badge-success"> Pinjaman Kapitalisasi</span>';
    } else if (value == 'Pinjaman Umum') {
        return '<span class="badge badge-primary"> Pinjaman Umum</span>';
    } else if (value == 'Pinjaman Produktif') {
        return '<span class="badge badge-green"> Pinjaman Produktif</span>';
    }
    return '';
}

export function notificationIcon(value) {
    if (value == 'Menambah laporancu' || value == 'Mengubah laporancu' || value == 'Menghapus laporancu') {
        return '<i class="icon-stats-bars2"></i>';
    } else if (value == 'Menambah diskusilaporan' || value == 'Menulis diskusilaporan' || value == 'Mengubah laporancu' || value == 'Menghapus laporancu') {
        return '<i class="icon-bubble2"></i>';
    }
    return '';
}

// Export all functions as default object for convenience
export default {
    // Date & Time
    date,
    time,
    dateTime,
    dateMonth,
    month,
    year,
    relativeHour,
    age,
    ageDiff,

    // String
    uppercase,
    trimString,

    // Number
    currency,
    number,
    percentage,
    percentage2,
    round,

    // Status
    checkStatus,
    statusDiklat,
    statusPeserta,
    statusJalinan,
    statusKlaimJalinan,

    // Type/Category
    checkTingkatAktivis,
    kegiatanTipe,
    tipeRekom,
    tipeProdukCu,
    notificationIcon
};
