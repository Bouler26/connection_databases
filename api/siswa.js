import fs from "fs";
import path from "path";

export default function handler(req, res) {
  const filePath = path.join(process.cwd(), "data", "siswa.json");

  try {
    const jsonData = fs.readFileSync(filePath, "utf-8");
    const siswa = JSON.parse(jsonData);

    res.status(200).json({
      success: true,
      data: siswa,
    });
  } catch (error) {
    res.status(500).json({
      success: false,
      message: "Gagal membaca file JSON",
      error: error.message,
    });
  }
}