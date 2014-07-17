Simple rel=canonical for ExpressionEngine
================================

### Installation
Copy `pb_relcanonical` folder to `/system/ExpressionEngine/third_party`

### Usage
`{exp:pb_relcanonical:linkmeta strip_last_slash="yes"}`
will output
`<link rel="canonical" href="http://example.com/example" />`

### Notes
- Removes standard EE pagination (`/P8` etc.) from `href`
- Set `strip_last_slash` to `yes` or `no` as per your site's current SEO standard
- Tag will automatically match the protocol used on each page, `http` or `https`
- Outputs all segments
- Removes query parameters

