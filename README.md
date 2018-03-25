# emarsys
An eZ Publish 4.x extension for interaction with the Emarsys API ( Emarsys.com )

## Installation

### WebExtend scripts
1. Add your MerchantID to emarsys.ini, under [WebExtend]
2. Add {include uri="design:emarsys_web_extend-tracking.tpl"} just before </head> in your page_head.tpl (or similar).
3. Add {include uri="design:emarsys_web_extend-go.tpl"} before </html> in pagelayout.tpl (or similar).
4. View Command - add {include uri="design:emarsys_web_extend-view.tpl" product_id=$product_id} to your product page, ensuring that the correct ItemID is set in $product_id
5. Category Command - add {include uri="design:emarsys_web_extend-category.tpl"} to your category pages
