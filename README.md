**SQL Query:**

WITH RECURSIVE date_series AS (
    SELECT '2026-05-01' AS day
    UNION ALL
    SELECT day + INTERVAL 1 DAY
    FROM date_series
    WHERE day + INTERVAL 1 DAY <= '2026-05-31'
)
SELECT
    ds.day,
    COUNT(r.id) AS visitors_count
FROM date_series ds
         LEFT JOIN reservations r
                   ON r.reservation_date = ds.day
GROUP BY ds.day
ORDER BY ds.day;
