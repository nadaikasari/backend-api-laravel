### request body untuk create list note
```bash
{
  "content": [
    {
      "item": "belanja bulanan",
      "is_checked": false,
      "children": [
        {
          "id": 1,
          "item": "sayur",
          "is_checked": false
        },
        {
            "id": 2,
          "item": "tempe",
          "is_checked": false
        }
      ]
    },
    {
      "item": "skincare",
      "is_checked": false,
      "children": [
        {
            "id": 3,
          "item": "toner",
          "is_checked": false
        },
        {
            "id": 4,
          "item": "bedak",
          "is_checked": false
        }
      ]
    }
  ]
}

```
