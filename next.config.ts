import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  // ponytail: standalone utk deploy tanpa npm di shared hosting (cPanel/Passenger)
  output: "standalone",
  // sharp tidak tersedia tanpa npm di server -> matikan optimasi gambar
  images: { unoptimized: true },
};

export default nextConfig;
