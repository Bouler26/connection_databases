import fs from "fs";
import path from "path";

export default function handler(req, res) {
  try {
    const filePath = path.join(process.cwd(), "data", "siswa.json");

    // Cek file benar-benar JSON, bukan module
    if (path.extname(filePath) !== ".json") {
      throw new Error("File bukan JSON");
    }

    const raw = fs.readFileSync(filePath, "utf8");
    const data = JSON.parse(raw);

    return res.status(200).json({
      success: true,
      data,
    });

  } catch (err) {
    return res.status(500).json({
      success: false,
      message: "Error membaca JSON",
      error: err.message,
    });
  }
}