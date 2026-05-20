const ENDPOINTS = {
  auth: {
    login: '/api/login',
  },

  dosen: {
    all: '/api/dosen',
    tambah: '/api/dosen',
    edit: (id) => `/api/dosen/${id}`,
    hapus: (id) => `/api/dosen/${id}`,
  },

  kelas: {
    list: null,
    start: '/api/kelas/start',
    end: '/api/kelas/end',
  },

  qr: {
    generate: '/api/qr/generate',
    testScan: '/api/qr/test-scan',
  },

  absensi: {
    manual: 'http://127.0.0.1:8000/api/absensi/manual',
    rekap: '/api/absensi/rekap',
    },
}

export default ENDPOINTS
