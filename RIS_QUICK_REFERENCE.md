# RIS Download Feature - Quick Reference

## 🎯 What Users Can Do

Users can now easily download paper citations in **RIS format** (.ris files) from the journal system and import them directly into their favorite reference management tools:

- **Zotero** - Free, open-source reference manager
- **Mendeley** - Research collaboration platform  
- **EndNote** - Professional bibliography software
- **RefWorks** - Web-based citation manager
- **Google Scholar** - Academic search engine
- And any other tool that supports RIS format

---

## 📍 Where to Find It

### On Published Papers Listing
Each paper card displays an **"Export Citation"** button below the abstract, allowing quick RIS downloads.

### On Individual Paper Page
In the **Citation section**, there are two buttons:
1. **"Cite This Paper"** - Opens a modal with various citation formats
2. **"Export as RIS"** - Downloads the RIS file directly

---

## 📥 How to Use

### Example: Importing into Zotero

1. Go to a published paper on the journal system
2. Click **"Export Citation"** or **"Export as RIS"** button
3. Save the `.ris` file to your computer
4. Open Zotero
5. Go to **File → Import**
6. Select the downloaded `.ris` file
7. Citation automatically added to your library ✅

### Example: Importing into Mendeley

1. Click **"Export as RIS"** on any published paper
2. Open Mendeley Desktop
3. Navigate to **File → Import → Files**
4. Select the downloaded `.ris` file
5. Paper appears in your library ✅

---

## 📋 What's in the RIS File

The downloaded `.ris` file contains:

```
TY  - JOUR                           Type of reference (Journal Article)
ID  - 42                             Reference ID
TI  - Paper Title Here               Paper title
AU  - Author Last, First             Author name
PY  - 2024                           Publication year
AB  - Abstract text...               Paper abstract
KW  - Machine Learning               Keywords
TI  - AI Research                    Research field
JO  - IRJIEST Journal                Journal name
UR  - https://...                    Link to paper
N1  - Downloaded from IRJIEST        Notes
ER  -                                End of record
```

All this information is recognized by reference managers and automatically organized in your library.

---

## ✨ Key Features

✅ **One-click download**  
✅ **Works with all major reference managers**  
✅ **Automatic date and author formatting**  
✅ **Includes all key metadata**  
✅ **No account/login required** for published papers  
✅ **Bulk export capability** (future enhancement)  

---

## 🔗 Related Tools

If you're using these platforms, you can use RIS files:

| Tool | Support | Import Method |
|------|---------|---------------|
| Zotero | ✅ | File → Import |
| Mendeley | ✅ | File → Import → Files |
| EndNote | ✅ | File → Import |
| RefWorks | ✅ | Import Tab |
| Citavi | ✅ | Task → New → From RIS |
| Google Scholar | ✅ | My Citations → Import |
| BibDesk | ✅ | File → Open |

---

## 🛠️ Technical Details (For Developers)

### API Endpoint
```
GET /papers/{submission}/download-ris
```

### Response
- **Status**: 200 (Success) or 403 (Not Published)
- **Content-Type**: `application/x-research-info-systems`
- **File**: `.ris` with paper title as filename

### Implementation Files
- **Service**: `app/Services/RisExportService.php`
- **Controller**: `app/Http/Controllers/HomeController.php` (method: `downloadPublicPaperRis()`)
- **Route**: `routes/web.php`
- **Tests**: `tests/Feature/RisExportTest.php`

### Usage Example
```php
use App\Services\RisExportService;

$submission = Submission::find(42);
$service = app(RisExportService::class);
$ris = $service->generateRis($submission);
// Use $ris content...
```

---

## ❓ FAQ

### Q: Is my personal data included in the RIS file?
**A**: No. Only the paper's public metadata is included (title, authors, abstract, keywords, publication date).

### Q: Can I download RIS files for unpublished papers?
**A**: No, only published papers are available for download. This ensures only peer-reviewed content is exported.

### Q: Does importing into my reference manager duplicate my work?
**A**: No. Most reference managers detect duplicates automatically. Some offer duplicate detection settings.

### Q: What if the RIS file won't import?
**A**: Try these steps:
1. Verify the file has `.ris` extension
2. Try importing as "Generic RIS"
3. Check if your reference manager needs updating
4. Contact your reference manager's support

### Q: Can I bulk export citations?
**A**: Currently, single paper export is supported. Bulk export is planned for future updates.

### Q: If RIS doesn't work, what are alternatives?
**A**: You can:
1. Use the "Cite This Paper" button for manual copying
2. Contact your reference manager's support
3. Report the issue to IRJIEST

---

## 🚀 Future Enhancements

Planned improvements to citation export:

- [ ] **BibTeX export** (.bib format for LaTeX users)
- [ ] **APA/MLA/Chicago text formats** 
- [ ] **Bulk export** - Download multiple citations at once
- [ ] **CSL-JSON format** - Universal citation format
- [ ] **Zotero direct import** button (one-click) 
- [ ] **Browser extension** for easier access
- [ ] **API for developers** to integrate citations into external tools

---

## 📞 Support

For issues or questions:

1. **Technical issues**: Check [RIS_DOWNLOAD_FEATURE.md](RIS_DOWNLOAD_FEATURE.md) for detailed documentation
2. **Reference manager problems**: Contact your reference manager's support
3. **Feature requests**: Report to IRJIEST support team
4. **Multiple authors**: Currently exports first author; multi-author support coming

---

## 📚 Learn More

- [RIS Format Wikipedia](https://en.wikipedia.org/wiki/RIS_(file_format))
- [Zotero Documentation](https://www.zotero.org/support/)
- [Mendeley Support](https://www.elsevier.com/products/mendeley/mendeley-desktop)
- [EndNote Guides](https://endnote.com/guides/)

---

**Last Updated**: March 2026  
**Version**: 1.0
