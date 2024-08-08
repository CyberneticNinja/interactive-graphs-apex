-- SELECT 
--     strftime('%Y', order_date) as year, 
--     COUNT(*) as count 
-- FROM 
--     orders 
-- WHERE
--     strftime('%Y', order_date) = '2024'
-- GROUP BY 
--     strftime('%Y', order_date)
-- ORDER BY 
--     year;

SELECT 
    strftime('%Y', order_date) AS year, 
    strftime('%m', order_date) AS month, 
    COUNT(*) AS count 
FROM 
    orders 
WHERE 
    strftime('%Y', order_date) = '2022'
GROUP BY 
    year, 
    month 
ORDER BY 
    month;
