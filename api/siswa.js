import siswa from "../data/siswa.json";

export default function handler(req, res) {
  const { id } = req.query;

  // Jika mencari berdasarkan ID
  if (id) {
    const result = siswa.find((item) => item.id === parseInt(id));
    if (!result) {
      return res.status(404).json({
        status: false,
        message: "Data siswa tidak ditemukan"
      });
    }

    return res.status(200).json({
      status: true,
      data: result
    });
  }

  // Jika meminta semua siswa
  return res.status(200).json({
    status: true,
    total: siswa.length,
    data: siswa
  });
}