-- seed.sql — the starting rows. Import after schema.sql.
-- The nine areas from the booking form, then twelve sample bookings so
-- the Bookings list looks like a list straight away. The bookings are
-- made-up demo rows — the team can delete them from the Bookings page.
USE mwananchi_garbage;

INSERT INTO areas (id, name) VALUES
 (1, 'Westlands'),
 (2, 'Kilimani'),
 (3, 'Kileleshwa'),
 (4, 'Karen'),
 (5, 'Langata'),
 (6, 'Kasarani'),
 (7, 'Ruiru'),
 (8, 'Embakasi'),
 (9, 'Another area');

INSERT INTO bookings (fullname, phone, area_id, service, notes, created_at) VALUES
 ('Achieng Otieno', '0712345678', 2, 'Household collection', 'Gate code 1234', '2026-11-02 09:14:00'),
 ('Brian Mwangi', '0723456789', 4, 'Recycling', 'Cardboard and glass, every Friday', '2026-11-03 11:02:00'),
 ('Wanjiru Kamau', '0734567890', 7, 'Skip hire', 'One skip for a house move', '2026-11-05 08:47:00'),
 ('Peter Njoroge', '0745678901', 1, 'Business collection', 'Restaurant waste, twice a week', '2026-11-06 14:20:00'),
 ('Faith Chebet', '0756789012', 6, 'Household collection', 'Bin by the side gate', '2026-11-09 10:05:00'),
 ('David Kiprop', '0767890123', 5, 'One-off cleanup', 'Plot clearing after construction', '2026-11-11 13:38:00'),
 ('Mary Wambui', '0778901234', 3, 'Household collection', 'Extra pickup this week', '2026-11-13 09:51:00'),
 ('John Ouma', '0789012345', 8, 'Business collection', 'Workshop offcuts, Fridays', '2026-11-16 15:12:00'),
 ('Grace Nyambura', '0790123456', 4, 'Recycling', 'Plastic bottles from the school', '2026-11-18 08:29:00'),
 ('Samuel Kariuki', '0701234567', 7, 'Household collection', 'Call on arrival', '2026-11-19 12:44:00'),
 ('Lucy Auma', '0711223344', 2, 'Skip hire', 'Skip for a compound cleanup', '2026-11-20 10:17:00'),
 ('Kevin Maina', '0722334455', 1, 'One-off cleanup', 'Garage clear-out, Saturday', '2026-11-21 16:03:00');
