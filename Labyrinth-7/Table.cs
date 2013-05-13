namespace Labyrinth
{
    public class Table
    {
        public int Moves { get; set; }
        public string Name { get; set; };


        public Table(int moves, string name)
        {
            this.Moves = moves;
            this.Name = name;
        }
    }
}