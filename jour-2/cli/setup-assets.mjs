import * as cheerio from "cheerio";
import { resolve } from "node:path";
import { writeFile } from "node:fs/promises";

const website = "https://manybooks.net";
const categories = [
  "/categories/ADV",
  "/categories/AFR",
  "/categories/ART",
  "/categories/BAN",
  "/categories/BIO",
  "/categories/BUS",
  "/categories/CAN",
  "/categories/CLA",
  "/categories/COM",
  "/categories/COO",
  "/categories/COR",
  "/categories/CCL",
  "/categories/CRI",
  "/categories/DRA",
  "/categories/SPY",
  "/categories/ESS",
  "/categories/ETT",
  "/categories/FAN",
  "/categories/FIC",
  "/categories/GAM",
  "/categories/GAY",
  "/categories/GHO",
  "/categories/GOT",
  "/categories/GOV",
  "/categories/HAR",
  "/categories/HEA",
  "/categories/HIS",
  "/categories/HOR",
  "/categories/HUM",
  "/categories/INS",
  "/categories/LAN",
  "/categories/MUS",
  "/categories/MYS",
  "/categories/MYT",
  "/categories/NAT",
  "/categories/NAU",
  "/categories/NON",
  "/categories/OCC",
  "/categories/PER",
  "/categories/PHI",
  "/categories/PIR",
  "/categories/POE",
  "/categories/POL",
  "/categories/MOD",
  "/categories/PSY",
  "/categories/PUL",
  "/categories/RAN",
  "/categories/REF",
  "/categories/REL",
  "/categories/ROM",
  "/categories/SAT",
  "/categories/SCI",
  "/categories/SFC",
  "/categories/sex",
  "/categories/SST",
  "/categories/SHO",
  "/categories/THR",
  "/categories/TRA",
  "/categories/WAR",
  "/categories/WES",
  "/categories/WOM",
  "/categories/CHI",
];

(async function () {
  const books = {};

  for (const category of categories) {
    const res = await fetch(`${website}${category}`);
    if (!res.ok) {
      console.log(category, "was ignored!");
      continue;
    }

    const $ = cheerio.load(await res.text());
    const genre = $(".mb-genre-search-title > .mb-title").text();

    $(".region-content .view-content > .views-row").each((idx, el) => {
      let book = "";
      const container = $(el);
      for (const item of container.find('.content a[href^="/titles/"]')) {
        if ($(item).find("img").length) {
          continue;
        }
        book = $(item).text().trim().replace(/^'/, "");
      }

      if (!books[genre]) {
        books[genre] = [];
      }
      books[genre].push(book);
    });

    books[genre] = books[genre].filter((a) => a);
  }

  await writeFile(
    resolve("./cli/seeders/books.json"),
    JSON.stringify(books, null, 2),
    {
      encoding: "utf-8",
    }
  );
})();
